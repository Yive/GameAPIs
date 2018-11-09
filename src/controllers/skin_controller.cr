require "cossack"
require "base64"
require "redis"

class SkinController < ApplicationController
  def skin
    name = params[:user].nil? ? "steve" : "#{params[:user]}".downcase.delete('-')
    response.content_type = "image/png"
    "#{name.delete('_')}".each_char do |char|
      if !char.alphanumeric?
        response.status_code = 400
        return File.read("steve.png")
      end
    end
    if name.size < 32
      return File.read("steve.png")
    end
    begin
      redis = Redis.new(unixsocket: "/var/run/redis/redis-server2.sock") # I know it's hard coded, but whatever.
      if redis.exists("skins_server:rawskins:#{name}") == 1
        check = redis.get("skins_server:rawskins:#{name}")
        redis.close
        return Base64.decode_string(check) if !check.nil?
        return File.read("steve.png")
      end
      if redis.exists("skins_server:profiles:#{name}") == 1
        check_redis = redis.get("skins_server:profiles:#{name}")
        if !check_redis.nil?
          check = JSON.parse(check_redis)
          if check["properties_decoded"]["textures"]["SKIN"]? == nil
            redis.close
            return File.read("steve.png")
          end
          skin = Cossack.get("#{check["properties_decoded"]["textures"]["SKIN"]["url"]}")
          if skin.status != 200
            redis.close
            return File.read("steve.png")
          end
          redis.setex("skins_server:rawskins:#{check["id"]}", 3600, Base64.encode(skin.body))
          redis.setex("skins_server:rawskins:#{check["name"]}".downcase, 3600, Base64.encode(skin.body))
          redis.close
          return skin.body
        end
        redis.close
        return File.read("steve.png")
      end
      ss = Cossack.get("https://sessionserver.mojang.com/session/minecraft/profile/#{name.delete('-')}?unsigned=false")
      if ss.status != 200
        redis.close
        return File.read("steve.png")
      end
      profile = JSON.parse(ss.body)
      value = JSON.parse(Base64.decode_string("#{profile["properties"][0]["value"]}"))
      formatted = "#{profile["id"]}".insert(20,'-')
      formatted = "#{formatted}".insert(16,'-')
      formatted = "#{formatted}".insert(12,'-')
      formatted = "#{formatted}".insert(8,'-')
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
      properties = JSON.parse(Base64.decode_string("#{profile["properties"][0]["value"]}"))
      if properties["textures"]["SKIN"]? == nil
        redis.setex("skins_server:rawskins:#{profile["id"]}", 3600, Base64.encode(File.read("steve.png")))
        redis.setex("skins_server:rawskins:#{profile["name"]}".downcase, 3600, Base64.encode(File.read("steve.png")))
        redis.close
        return File.read("steve.png")
      else
        skin = Cossack.get("#{properties["textures"]["SKIN"]["url"]}")
        if skin.status == 200
          redis.setex("skins_server:rawskins:#{profile["id"]}", 3600, Base64.encode(skin.body))
          redis.setex("skins_server:rawskins:#{profile["name"]}".downcase, 3600, Base64.encode(skin.body))
          redis.close
          return skin.body
        else
          redis.setex("skins_server:rawskins:#{profile["id"]}", 3600, Base64.encode(File.read("steve.png")))
          redis.setex("skins_server:rawskins:#{profile["name"]}".downcase, 3600, Base64.encode(File.read("steve.png")))
          redis.close
          return File.read("steve.png")
        end
      end
    rescue e
      puts e
      if !redis.nil?
        redis.close
      end
      return File.read("steve.png")
    end
  end
end