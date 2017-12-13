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
                skin = LibMagick.newMagickWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                helmet = LibMagick.cloneMagickWand skin
                LibMagick.magickCropImage helmet, 8, 8, 40, 8
                n = 0
                m = 0
                plainHelmet = false
                p_wand = LibMagick.newPixelWand
                LibMagick.magickGetImagePixelColor(skin, 0, 0, p_wand)
                startColour = String.new(LibMagick.pixelGetColorAsNormalizedString(p_wand))
                while n <= 8
                    while m <=8
                        LibMagick.magickGetImagePixelColor(helmet, n, m, p_wand)
                        if String.new(LibMagick.pixelGetColorAsNormalizedString(p_wand)) == startColour
                            if String.new(LibMagick.pixelGetColorAsNormalizedString(p_wand)) != "0,0,0,1"
                                plainHelmet = true
                                break
                            end
                        end
                        m += 1
                    end
                    if plainHelmet
                        break
                    end
                    n += 1
                end
                LibMagick.destroyPixelWand p_wand
                LibMagick.magickCropImage skin, 8, 8, 8, 8
                if !plainHelmet
                    LibMagick.magickCompositeImage skin, helmet, LibMagick::CompositeOperator::OverCompositeOp, 0, 0
                end
                LibMagick.magickScaleImage skin, size, size
                buffer = LibMagick.magickGetImageBlob skin, out length
                slice = Slice.new( buffer, length )
                redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand skin
                LibMagick.destroyMagickWand helmet
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
                skin = LibMagick.newMagickWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                LibMagick.magickCropImage skin, 8, 8, 8, 8
                LibMagick.magickScaleImage skin, size, size
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
                skin = LibMagick.newMagickWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                helmet = LibMagick.cloneMagickWand skin
                LibMagick.magickCropImage helmet, 8, 8, 40, 8
                n = 0
                m = 0
                plainHelmet = false
                p_wand = LibMagick.newPixelWand
                LibMagick.magickGetImagePixelColor(skin, 0, 0, p_wand)
                startColour = String.new(LibMagick.pixelGetColorAsNormalizedString(p_wand))
                while n <= 8
                    while m <=8
                        LibMagick.magickGetImagePixelColor(helmet, n, m, p_wand)
                        if String.new(LibMagick.pixelGetColorAsNormalizedString(p_wand)) == startColour
                            if String.new(LibMagick.pixelGetColorAsNormalizedString(p_wand)) != "0,0,0,1"
                                plainHelmet = true
                                break
                            end
                        end
                        m += 1
                    end
                    if plainHelmet
                        break
                    end
                    n += 1
                end
                LibMagick.destroyPixelWand p_wand
                LibMagick.magickCropImage skin, 8, 8, 8, 8
                if !plainHelmet
                    LibMagick.magickCompositeImage skin, helmet, LibMagick::CompositeOperator::OverCompositeOp, 0, 0
                end
                LibMagick.magickScaleImage skin, size, size
                buffer = LibMagick.magickGetImageBlob skin, out length
                slice = Slice.new( buffer, length )
                redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand skin
                LibMagick.destroyMagickWand helmet
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
                skin = LibMagick.newMagickWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                LibMagick.magickCropImage skin, 8, 8, 8, 8
                LibMagick.magickScaleImage skin, size, size
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
    add_handler StandardAvatar.new
    add_handler StandardAvatarWithoutHelmet.new
    add_handler ResizableAvatar.new
    add_handler ResizableAvatarWithoutHelmet.new
end