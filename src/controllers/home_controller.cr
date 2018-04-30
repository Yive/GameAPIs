class HomeController < ApplicationController
  def index
    response.content_type = "text/plain"
    info = "Raw Skin File (image/png): https://ss.gameapis.net/raw/<uuid/username>\n" +
    "- Usernames are supported, but will only display the default steve skin if that user's UUID has not been requested recently.\n\n" +
    "Skins are cached for 60 minutes.\n\n" +
    "UUID -> Name (application/json):https://ss.gameapis.net/name/<uuid>\n" +
    "UUID -> Profile (application/json): https://ss.gameapis.net/profile/<uuid>\n\n" +
    "UUID -> Name & UUID -> Profile are cached for 12 hours."
    return info
  end
end