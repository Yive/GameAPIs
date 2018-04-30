require "cossack"
require "base64"

class SkinController < ApplicationController
  def skin
    name = params[:user].nil? ? "steve" : "#{params[:user]}".downcase
    response.content_type = "image/png"
    begin
      if File.exists?("#{Dir.current}/apis/rawskins/#{name.delete('-')}.png")
        if Time.now.epoch - File.stat("#{Dir.current}/apis/rawskins/#{name.delete('-')}.png").mtime.epoch < 3600
          check = File.read("#{Dir.current}/apis/rawskins/#{name.delete('-')}.png")
          return check if !check.nil?
        else
          File.delete("#{Dir.current}/apis/rawskins/#{name.delete('-')}.png")
        end
        return File.read("steve.png")
      end
      if File.exists?("#{Dir.current}/apis/profiles/#{name.delete('-')}.txt".downcase)
        if Time.now.epoch - File.stat("#{Dir.current}/apis/profiles/#{name.delete('-')}.txt".downcase).mtime.epoch < 3600
          check = JSON.parse(File.read("#{Dir.current}/apis/profiles/#{name.delete('-')}.txt".downcase))
          properties = JSON.parse(Base64.decode_string("#{check["properties"][0]["value"]}"))
          return File.read("steve.png") if properties["textures"]["SKIN"]? == nil
          skin = Cossack.get("#{properties["textures"]["SKIN"]["url"]}")
          return File.read("steve.png") if skin.status != 200
          File.write("#{Dir.current}/apis/rawskins/#{check["id"]}.png", skin.body) if !File.exists?("#{Dir.current}/apis/rawskins/#{check["id"]}.png")
          File.write("#{Dir.current}/apis/rawskins/#{check["name"]}.png".downcase, skin.body) if !File.exists?("#{Dir.current}/apis/rawskins/#{check["name"]}.png".downcase)
          return skin.body
        else
          File.delete("#{Dir.current}/apis/profiles/#{name.delete('-')}.txt".downcase)
        end
      end
      if name.size < 32
        return File.read("steve.png")
      end
      ss = Cossack.get("https://sessionserver.mojang.com/session/minecraft/profile/#{name.delete('-')}?unsigned=false")
      if ss.status != 200
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
      File.write("#{Dir.current}/apis/profiles/#{profile["id"]}.txt", "#{save.to_s}")
      File.write("#{Dir.current}/apis/profiles/#{profile["name"]}.txt".downcase, "#{save.to_s}")
      properties = JSON.parse(Base64.decode_string("#{profile["properties"][0]["value"]}"))
      if properties["textures"]["SKIN"]? == nil
        File.write("#{Dir.current}/apis/uuids/#{profile["id"]}.txt", "#{profile["id"]}")
        File.write("#{Dir.current}/apis/rawskins/#{profile["id"]}.png", File.read("steve.png"))
        File.write("#{Dir.current}/apis/rawskins/#{profile["name"]}.png".downcase, File.read("steve.png"))
        return File.read("steve.png")
      else
        skin = Cossack.get("#{properties["textures"]["SKIN"]["url"]}")
        if skin.status == 200
          File.write("#{Dir.current}/apis/uuids/#{profile["id"]}.txt", "#{profile["id"]}")
          File.write("#{Dir.current}/apis/rawskins/#{profile["id"]}.png", skin.body)
          File.write("#{Dir.current}/apis/rawskins/#{profile["name"]}.png".downcase, skin.body)
          return skin.body
        else
          File.write("#{Dir.current}/apis/uuids/#{profile["id"]}.txt", "#{profile["id"]}")
          File.write("#{Dir.current}/apis/rawskins/#{profile["id"]}.png", File.read("steve.png"))
          File.write("#{Dir.current}/apis/rawskins/#{profile["name"]}.png".downcase, File.read("steve.png"))
          return File.read("steve.png")
        end
      end
    rescue e
      puts e
      return File.read("steve.png")
    end
    return File.read("steve.png")
  end
end