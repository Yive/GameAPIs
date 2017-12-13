module GameAPIs
    get "/" do |ctx|
        ctx.redirect "https://docs.gameapis.net/"
    end
end
