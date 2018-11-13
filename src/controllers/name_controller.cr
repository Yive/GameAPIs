require "cossack"
require "redis"

class NameController < ApplicationController
  def name
    name = params[:user].nil? ? "steve" : "#{params[:user]}".downcase.delete('-')
    response.content_type = "application/json"
    "#{name.delete('_')}".each_char do |char|
      if !char.alphanumeric?
        response.status_code = 400
        return "{\"error\": \"UUID is not alphanumeric.\"}"
      end
    end
    if name.size < 32
      response.status_code = 400
      return "{\"error\": \"UUIDs are only accepted.\"}"
    end
    begin
      redis = Redis.new(unixsocket: "/var/run/redis/redis-server2.sock") # I know it's hard coded, but whatever.
      if redis.exists("skins_server:skip:#{name}") == 1
        redis.close
        return "{\"error\": \"not a real UUID.\"}"
      end
      if redis.exists("skins_server:profiles:#{name}") == 1
        profile_redis = redis.get("skins_server:profiles:#{name}")
        if !profile_redis.nil?
          profile = JSON.parse(profile_redis)
          string = JSON.build do |json|
            json.object do
              json.field "name", "#{profile["name"]}"
              json.field "id", "#{profile["id"]}"
              json.field "uuid_formatted", "#{profile["uuid_formatted"]}"
            end
          end
          redis.close
          return "#{JSON.parse(string).to_json}"
        end
      end
      ss = Cossack.get("https://sessionserver.mojang.com/session/minecraft/profile/#{name}?unsigned=false")
      response.status_code = 400
      if ss.status != 200
        response.status_code = 400
        redis.setex("skins_server:skip:#{name}", 600, "1")
        redis.close
        response.headers.add("Cache-Control", "s-maxage=600, max-age=600")
        return "{\"error\": \"Not a real UUID for the username: #{name}?\"}"
      end
      response.status_code = 200
      profile = JSON.parse(ss.body)
      if !profile["id"].nil?
        value = JSON.parse(Base64.decode_string("#{profile["properties"][0]["value"]}"))
        formatted = "#{profile["id"]}".insert(19,'-')
        formatted = "#{formatted}".insert(15,'-')
        formatted = "#{formatted}".insert(11,'-')
        formatted = "#{formatted}".insert(7,'-')
        save = JSON.build do |json|
          json.object do
            json.field "name", "#{profile["name"]}"
            json.field "id", "#{profile["id"]}"
            json.field "uuid_formatted", "#{formatted}"
            json.field "properties" do
              json.array do
                json.object do
                  json.field "name", "textures"
                  json.field "value", "#{profile["properties"][0]["value"]}"
                  json.field "signature", "#{profile["properties"][0]["signature"]}"
                end
              end
            end
            json.field "properties_decoded" do
              json.object do
                json.field "timestamp" do
                  json.number "#{value["timestamp"]}".to_i64
                end
                json.field "profileId", "#{value["profileId"]}"
                json.field "profileName", "#{value["profileName"]}"
                json.field "signatureRequired" do
                  json.bool true
                end
                json.field "textures" do
                  json.object do
                    if value["textures"]["SKIN"]? != nil
                      json.field "SKIN" do
                        json.object do
                          json.field "url", "#{value["textures"]["SKIN"]["url"]}"
                          if value["textures"]["SKIN"]["metadata"]? != nil
                            json.field "metadata" do
                              json.object do
                                json.field "model", "slim"
                              end
                            end
                          end
                        end
                      end
                    end
                    if value["textures"]["CAPE"]? != nil
                      json.field "CAPE" do
                        json.object do
                          json.field "url", "#{value["textures"]["CAPE"]["url"]}"
                        end
                      end
                    end
                  end
                end
              end
            end
          end
        end
        redis.set("skins_server:uuids:#{profile["id"]}", "#{profile["id"]}")
        redis.setex("skins_server:profiles:#{profile["id"]}", 43_200, "#{save.to_s}")
        redis.setex("skins_server:profiles:#{profile["name"]}".downcase, 43_200, "#{save.to_s}")
        string = JSON.build do |json|
          json.object do
            json.field "name", "#{profile["name"]}"
            json.field "id", "#{profile["id"]}"
            json.field "uuid_formatted", "#{formatted}"
          end
        end
        redis.close
        response.headers.add("Cache-Control", "s-maxage=43200, max-age=43200")
        return "#{JSON.parse(string).to_json}"
      else
        redis.close
        return "{\"error\": \"id missing from mojang response.\"}"
      end
    rescue e
      puts e
      response.status_code = 500
      if !redis.nil?
        redis.close
      end
      return "{\"error\": \"Internal Server Error.\"}"
    end
  end
end