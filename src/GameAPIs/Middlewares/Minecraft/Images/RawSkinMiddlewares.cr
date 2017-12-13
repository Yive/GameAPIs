module GameAPIs
    class RawSkin < Kemal::Handler
        only ["/mc/images/rawskin/:name"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            redisKey = "#{ENV["REDIS_MCPC_SKIN_RAWFILE"]}#{name}"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                skin = LibMagick.newMagickWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                buffer = LibMagick.magickGetImageBlob skin, out length
                slice = Slice.new( buffer, length )
                redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand skin
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
end