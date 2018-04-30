require "cossack"

class ProfileController < ApplicationController
  def profile
    name = params[:user].nil? ? "steve" : "#{params[:user]}".downcase.delete('-')
    response.content_type = "application/json"
    "#{name.delete('_')}".each_char do |char|
      if !char.alphanumeric?
        response.status_code = 400
        return "{\"error\": \"UUID is not alphanumeric.\"}"
      end
    end
    begin
      if File.exists?("#{Dir.current}/apis/skip/#{name}.txt")
        if Time.now.epoch - File.stat("#{Dir.current}/apis/skip/#{name}.txt").mtime.epoch < 600
          return "{\"error\": \"not a real username.\"}"
        else
          File.delete("#{Dir.current}/apis/skip/#{name}.txt")
        end
      end
      if File.exists?("#{Dir.current}/apis/profiles/#{name}.txt".downcase)
        if Time.now.epoch - File.stat("#{Dir.current}/apis/profiles/#{name}.txt".downcase).mtime.epoch < 43200
          profile = JSON.parse(File.read("#{Dir.current}/apis/profiles/#{name}.txt".downcase))
          return profile.to_json.to_s
        else
          File.delete("#{Dir.current}/apis/profiles/#{name}.txt".downcase)
        end
      end
      if name.size < 32
        response.status_code = 400
        return "{\"error\": \"not a real username.\"}" if name.size > 16
        response.status_code = 200
        if File.exists?("#{Dir.current}/apis/skip/skip-all.txt")
          if Time.now.epoch - File.stat("#{Dir.current}/apis/skip/skip-all.txt").mtime.epoch < 600
            return "{\"error\": \"Mojang rate limit detected, check back soon.\"}"
          else
            File.delete("#{Dir.current}/apis/skip/skip-all.txt")
          end
        end
        id = Cossack.get("https://api.mojang.com/users/profiles/minecraft/#{name}")
        if id.status == 429
          File.write("#{Dir.current}/apis/skip/skip-all.txt", "1")
          return "{\"error\": \"Mojang rate limit detected, check back soon.\"}"
        end
        if id.status != 200
          response.status_code = 400
          File.write("#{Dir.current}/apis/skip/#{name}.txt", "1")
          return "{\"error\": \"Not a real username.\"}"
        end
        getid = JSON.parse(id.body)
        if "#{getid["id"]}".empty?
          response.status_code = 400
          File.write("#{Dir.current}/apis/skip/#{name}.txt", "1")
          return "{\"error\": \"id missing from mojang response.\"}"
        else
          name = "#{getid["id"]}"
        end
      end
      response.status_code = 400
      ss = Cossack.get("https://sessionserver.mojang.com/session/minecraft/profile/#{name}?unsigned=false")
      if ss.status != 200
        return "{\"error\": \"not a real UUID.\"}"
      end
      response.status_code = 200
      profile = JSON.parse(ss.body)
      if !profile["id"].nil?
        value = JSON.parse(Base64.decode_string("#{profile["properties"][0]["value"]}"))
        formatted = "#{profile["id"]}".insert(19,'-')
        formatted = "#{formatted}".insert(15,'-')
        formatted = "#{formatted}".insert(11,'-')
        formatted = "#{formatted}".insert(7,'-')
        string = JSON.build do |json|
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
        File.write("#{Dir.current}/apis/uuids/#{profile["id"]}.txt", "#{profile["id"]}") if !File.exists?("#{Dir.current}/apis/uuids/#{profile["id"]}.txt")
        File.write("#{Dir.current}/apis/profiles/#{profile["id"]}.txt", "#{string.to_s}")
        File.write("#{Dir.current}/apis/profiles/#{profile["name"]}.txt".downcase, "#{string.to_s}")
        return string.to_s
      else
        return "{\"error\": \"id missing from mojang response.\"}"
      end
    rescue e
      puts e
      response.status_code = 500
      return "{\"error\": \"Internal Server Error.\"}"
    end
  end

  def name
    name = params[:user].nil? ? "steve" : "#{params[:user]}".downcase.delete('-')
    response.content_type = "application/json"
    name.each_char do |char|
      if !char.alphanumeric?
        response.status_code = 400
        return "{\"error\": \"UUID is not alphanumeric.\"}"
      end
    end
    begin
      if File.exists?("#{Dir.current}/apis/skip/#{name}.txt")
        if Time.now.epoch - File.stat("#{Dir.current}/apis/skip/#{name}.txt").mtime.epoch < 600
          return "{\"error\": \"not a real UUID.\"}"
        else
          File.delete("#{Dir.current}/apis/skip/#{name}.txt") if File.exists?("#{Dir.current}/apis/skip/#{name}.txt")
        end
      end
      if File.exists?("#{Dir.current}/apis/profiles/#{name}.txt".downcase)
        if Time.now.epoch - File.stat("#{Dir.current}/apis/profiles/#{name}.txt".downcase).mtime.epoch < 43200
          profile = JSON.parse(File.read("#{Dir.current}/apis/profiles/#{name}.txt".downcase))
          formatted = "#{profile["id"]}".insert(19,'-')
          formatted = "#{formatted}".insert(15,'-')
          formatted = "#{formatted}".insert(11,'-')
          formatted = "#{formatted}".insert(7,'-')
          string = JSON.build do |json|
            json.object do
              json.field "name", "#{profile["name"]}"
              json.field "id", "#{profile["id"]}"
              json.field "uuid_formatted", "#{formatted}"
            end
          end
          return "#{JSON.parse(string).to_json}"
        else
          File.delete("#{Dir.current}/apis/profiles/#{name}.txt".downcase)
        end
      end
      response.status_code = 400
      if name.size < 32
        return "{\"error\": \"UUIDs are only accepted.\"}"
      end
      ss = Cossack.get("https://sessionserver.mojang.com/session/minecraft/profile/#{name}?unsigned=false")
      if ss.status != 200
        File.write("#{Dir.current}/apis/skip/#{name}.txt", "1")
        return "{\"error\": \"not a real UUID.\"}"
      end
      response.status_code = 200
      profile = JSON.parse(ss.body)
      if !profile["id"].nil?
        File.write("#{Dir.current}/apis/uuids/#{profile["id"]}.txt", "#{profile["id"]}") if !File.exists?("#{Dir.current}/apis/uuids/#{profile["id"]}.txt")
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
        File.write("#{Dir.current}/apis/profiles/#{profile["id"]}.txt", "#{save.to_s}")
        File.write("#{Dir.current}/apis/profiles/#{profile["name"]}.txt".downcase, "#{save.to_s}")
        string = JSON.build do |json|
          json.object do
            json.field "name", "#{profile["name"]}"
            json.field "id", "#{profile["id"]}"
            json.field "uuid_formatted", "#{formatted}"
          end
        end
        return "#{JSON.parse(string).to_json}"
      else
        return "{\"error\": \"id missing from mojang response.\"}"
      end
    rescue e
      puts e
      response.status_code = 500
      return "{\"error\": \"Internal Server Error.\"}"
    end
  end

  def uuid
    name = params[:user].nil? ? "steve" : "#{params[:user]}".downcase.delete('-')
    response.content_type = "application/json"
    name.delete('_').each_char do |char|
      if !char.alphanumeric?
        response.status_code = 400
        return "{\"error\": \"Username is not alphanumeric.\"}"
      end
    end
    begin
      if File.exists?("#{Dir.current}/apis/skip/skip-all.txt")
        if Time.now.epoch - File.stat("#{Dir.current}/apis/skip/skip-all.txt").mtime.epoch < 600
          return "{\"error\": \"Mojang rate limit detected, check back soon.\"}"
        else
          File.delete("#{Dir.current}/apis/skip/skip-all.txt")
        end
      end
      if File.exists?("#{Dir.current}/apis/skip/#{name}.txt")
        if Time.now.epoch - File.stat("#{Dir.current}/apis/skip/#{name}.txt").mtime.epoch < 600
          return "{\"error\": \"not a real username.\"}"
        else
          File.delete("#{Dir.current}/apis/skip/#{name}.txt")
        end
      end
      if File.exists?("#{Dir.current}/apis/profiles/#{name}.txt".downcase)
        if Time.now.epoch - File.stat("#{Dir.current}/apis/profiles/#{name}.txt".downcase).mtime.epoch < 43200
          profile = JSON.parse(File.read("#{Dir.current}/apis/profiles/#{name}.txt".downcase))
          formatted = "#{profile["id"]}".insert(19,'-')
          formatted = "#{formatted}".insert(15,'-')
          formatted = "#{formatted}".insert(11,'-')
          formatted = "#{formatted}".insert(7,'-')
          string = JSON.build do |json|
            json.object do
              json.field "name", "#{profile["name"]}"
              json.field "id", "#{profile["id"]}"
              json.field "uuid_formatted", "#{formatted}"
            end
          end
          return "#{JSON.parse(string).to_json}"
        else
          File.delete("#{Dir.current}/apis/profiles/#{name}.txt".downcase)
        end
      end
      response.status_code = 400
      if name.size > 16
        return "{\"error\": \"Usernames are only accepted.\"}"
      end
      id = Cossack.get("https://api.mojang.com/users/profiles/minecraft/#{name}")
      if id.status == 429
        File.write("#{Dir.current}/apis/skip/skip-all.txt", "1")
        return "{\"error\": \"Mojang rate limit detected, check back soon.\"}"
      end
      if id.status != 200
        File.write("#{Dir.current}/apis/skip/#{name}.txt", "1")
        return "{\"error\": \"Not a real username.\"}"
      end
      getid = JSON.parse(id.body)
      if !"#{getid["id"]}".empty?
        ss = Cossack.get("https://sessionserver.mojang.com/session/minecraft/profile/#{getid["id"]}?unsigned=false")
        if ss.status != 200
          File.write("#{Dir.current}/apis/skip/#{name}.txt", "1")
          return "{\"error\": \"Not a real UUID for the username: #{name}?\"}"
        end
        response.status_code = 200
        profile = JSON.parse(ss.body)
        if !profile["id"].nil?
          File.write("#{Dir.current}/apis/uuids/#{profile["id"]}.txt", "#{profile["id"]}") if !File.exists?("#{Dir.current}/apis/uuids/#{profile["id"]}.txt")
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
          File.write("#{Dir.current}/apis/profiles/#{profile["id"]}.txt", "#{save.to_s}")
          File.write("#{Dir.current}/apis/profiles/#{profile["name"]}.txt".downcase, "#{save.to_s}")
          string = JSON.build do |json|
            json.object do
              json.field "name", "#{profile["name"]}"
              json.field "id", "#{profile["id"]}"
              json.field "uuid_formatted", "#{formatted}"
            end
          end
          return "#{JSON.parse(string).to_json}"
        else
          return "{\"error\": \"id missing from mojang response.\"}"
        end
      else
        return "{\"error\": \"id missing from mojang response.\"}"
      end
    rescue e
      puts e
      response.status_code = 500
      return "{\"error\": \"Internal Server Error.\"}"
    end
  end
end