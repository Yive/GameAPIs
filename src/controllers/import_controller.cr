require "cossack"
require "redis"

class ImportController < ApplicationController
  def import
    name = params[:user].nil? ? "steve" : "#{params[:user]}".downcase
    response.content_type = "text/plain"
    if name == "steve" || name.size < 32
      response.status_code = 400
      return "UUID Required."
    end
    begin
      redis = Redis.new(unixsocket: "/var/run/redis/redis-server2.sock") # I know it's hard coded, but whatever.
      if redis.exists("skins_server:uuids:#{name.delete('-')}") == 1
        redis.close
        return "Duplicate"
      end
      response.status_code = 400
      ss = Cossack.get("https://sessionserver.mojang.com/session/minecraft/profile/#{name.delete('-')}?unsigned=false")
      if ss.status != 200
        redis.close
        return "Not a real UUID."
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
        redis.close
        return "Imported: #{profile["id"]} | #{profile["name"]}"
      end
      response.status_code = 500
      redis.close
      return "Something went wrong."
    rescue e
      puts e
      response.status_code = 500
      if !redis.nil?
        redis.close
      end
      return "Internal Server Error"
    end
  end
end