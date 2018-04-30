require "cossack"

class ImportController < ApplicationController
  def import
    name = params[:user].nil? ? "steve" : "#{params[:user]}".downcase
    response.content_type = "text/plain"
    begin
      if File.exists?("#{Dir.current}/apis/uuids/#{name.delete('-')}.txt")
        return "Duplicate"
      end
      response.status_code = 400
      if name.size < 32
        return "UUIDs are only accepted."
      end
      ss = Cossack.get("https://sessionserver.mojang.com/session/minecraft/profile/#{name.delete('-')}?unsigned=false")
      if ss.status != 200
        return "Not a real UUID."
      end
      response.status_code = 200
      json = JSON.parse(ss.body)
      if !"#{json["id"]}".empty?
        File.write("#{Dir.current}/apis/uuids/#{json["id"]}.txt", "#{json["id"]}")
        File.write("#{Dir.current}/apis/profiles/#{json["id"]}.txt", "#{json.to_s}")
        return "Imported: #{json["id"]} | #{json["name"]}"
      end
      response.status_code = 500
      return "Something went wrong."
    rescue e
      puts e
      response.status_code = 500
      return "Internal Server Error"
    end
  end
end