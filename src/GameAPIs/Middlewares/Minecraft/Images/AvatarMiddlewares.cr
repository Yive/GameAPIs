module GameAPIs
    class StandardAvatar < Kemal::Handler
        only ["/mc/images/avatar/:name", "/mc/images/avatar/:name/true"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            size = 100.to_u64
            redisKey = "#{ENV["REDIS_MCPC_AVATAR"]}#{name}:#{size}:true"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                wand = LibMagick.newMagickWand
                if LibMagick.magickReadImage( wand, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    wand2 = LibMagick.cloneMagickWand wand
                    LibMagick.magickCropImage wand2, 8, 8, 40, 8
                    LibMagick.magickCropImage wand, 8, 8, 8, 8
                    # TODO find method to check if the helmet is a solid colour.
                    LibMagick.magickCompositeImage wand, wand2, LibMagick::CompositeOperator::OverCompositeOp, 0, 0
                    LibMagick.magickScaleImage wand, size, size
                    buffer = LibMagick.magickGetImageBlob wand, out length
                    slice = Slice.new( buffer, length )
                    redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                    env.response.write(slice)
                end
                LibMagick.destroyMagickWand wand
                LibMagick.destroyMagickWand wand2
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    class StandardAvatarWithoutHelmet < Kemal::Handler
        only ["/mc/images/avatar/:name/false"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            size = 100.to_u64
            redisKey = "#{ENV["REDIS_MCPC_AVATAR"]}#{name}:#{size}:false"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                wand = LibMagick.newMagickWand
                if LibMagick.magickReadImage( wand, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickCropImage wand, 8, 8, 8, 8
                    LibMagick.magickScaleImage wand, size, size
                    buffer = LibMagick.magickGetImageBlob wand, out length
                    slice = Slice.new( buffer, length )
                    redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                    env.response.write(slice)
                end
                LibMagick.destroyMagickWand wand
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    class ResizableAvatar < Kemal::Handler
        only ["/mc/images/avatar/:name/:size", "/mc/images/avatar/:name/:size/true"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            size = env.params.url["size"].nil? ? 100.to_u64 : "#{env.params.url["size"]}".to_u64
            size = size < 8 ? 8.to_u64 : size
            redisKey = "#{ENV["REDIS_MCPC_AVATAR"]}#{name}:#{size}:true"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                wand = LibMagick.newMagickWand
                if LibMagick.magickReadImage( wand, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    wand2 = LibMagick.cloneMagickWand wand
                    LibMagick.magickCropImage wand2, 8, 8, 40, 8
                    LibMagick.magickCropImage wand, 8, 8, 8, 8
                    # TODO find method to check if the helmet is a solid colour.
                    LibMagick.magickCompositeImage wand, wand2, LibMagick::CompositeOperator::OverCompositeOp, 0, 0
                    LibMagick.magickScaleImage wand, size, size
                    buffer = LibMagick.magickGetImageBlob wand, out length
                    slice = Slice.new( buffer, length )
                    redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                    env.response.write(slice)
                end
                LibMagick.destroyMagickWand wand
                LibMagick.destroyMagickWand wand2
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    class ResizableAvatarWithoutHelmet < Kemal::Handler
        only ["/mc/images/avatar/:name/:size/false"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            size = env.params.url["size"].nil? ? 100.to_u64 : "#{env.params.url["size"]}".to_u64
            size = size < 8 ? 8.to_u64 : size
            redisKey = "#{ENV["REDIS_MCPC_AVATAR"]}#{name}:#{size}:false"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                wand = LibMagick.newMagickWand
                if LibMagick.magickReadImage( wand, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickCropImage wand, 8, 8, 8, 8
                    LibMagick.magickScaleImage wand, size, size
                    buffer = LibMagick.magickGetImageBlob wand, out length
                    slice = Slice.new( buffer, length )
                    redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                    env.response.write(slice)
                end
                LibMagick.destroyMagickWand wand
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    add_handler StandardAvatar.new
    add_handler StandardAvatarWithoutHelmet.new
    add_handler ResizableAvatar.new
    add_handler ResizableAvatarWithoutHelmet.new
end