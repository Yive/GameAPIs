module GameAPIs
    class StandardSkin < Kemal::Handler
        only ["/mc/images/skin/:name", "/mc/images/skin/:name/true"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            if name.size > 16
                name = "steve"
            end
            name.chars.each do |char|
                if /([A-Z_])/i.match(char.to_s).nil?
                    name = "steve"
                    break
                end
            end
            size = 85.to_u64
            redisKey = "#{ENV["REDIS_MCPC_SKIN_RENDER"]}#{name}:#{size}:withEverything"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                skin = LibMagick.newMagickWand
                bg_wand = LibMagick.newMagickWand
                bgp_wand = LibMagick.newPixelWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                checkHeight = LibMagick.magickGetImageHeight( skin ) === 32 ? 32 : 64
                # ------------------------------------------------- #
                #          Create transparent 16x32 image.          #
                # ------------------------------------------------- #
                LibMagick.pixelSetColor bgp_wand, "none"
                LibMagick.magickNewImage bg_wand, 16, 32, bgp_wand
                LibMagick.magickSetImageFormat bg_wand, "PNG"
                # ------------------------------------------------- #
                #                Clone skin 12 times                #
                # ------------------------------------------------- #
                head = LibMagick.cloneMagickWand skin
                helmet = LibMagick.cloneMagickWand skin
                chest = LibMagick.cloneMagickWand skin
                jacket = LibMagick.cloneMagickWand skin
                leftArm = LibMagick.cloneMagickWand skin
                leftSleeve = LibMagick.cloneMagickWand skin
                leftLeg = LibMagick.cloneMagickWand skin
                leftPantLeg = LibMagick.cloneMagickWand skin
                rightArm = LibMagick.cloneMagickWand skin
                rightSleeve = LibMagick.cloneMagickWand skin
                rightLeg = LibMagick.cloneMagickWand skin
                rightPantLeg = LibMagick.cloneMagickWand skin
                # ------------------------------------------------- #
                #      Crop images down to singular body parts      #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage helmet, 8, 8, 40, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 44, 20
                    LibMagick.magickCropImage leftLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                else
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage helmet, 8, 8, 40, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage jacket, 8, 12, 20, 36
                    LibMagick.magickCropImage leftArm, 4, 12, 36, 52
                    LibMagick.magickCropImage leftSleeve, 4, 12, 52, 52
                    LibMagick.magickCropImage leftLeg, 4, 12, 20, 52
                    LibMagick.magickCropImage leftPantLeg, 4, 12, 4, 52
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightSleeve, 4, 12, 44, 36
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightPantLeg, 4, 12, 4, 36
                end
                # ------------------------------------------------- #
                #       Merge body parts into the blank image       #
                # ------------------------------------------------- #
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
                if checkHeight === 32
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    if !plainHelmet
                        LibMagick.magickCompositeImage bg_wand, helmet, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    end
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                else
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    if !plainHelmet
                        LibMagick.magickCompositeImage bg_wand, helmet, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    end
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, jacket, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftSleeve, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, leftPantLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightSleeve, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                    LibMagick.magickCompositeImage bg_wand, rightPantLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                end
                # ------------------------------------------------- #
                LibMagick.magickResizeImage bg_wand, size, size * 2, LibMagick::FilterTypes::PointFilter, 0
                buffer = LibMagick.magickGetImageBlob bg_wand, out length
                slice = Slice.new( buffer, length )
                #redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand head
                LibMagick.destroyMagickWand helmet
                LibMagick.destroyMagickWand chest
                LibMagick.destroyMagickWand jacket
                LibMagick.destroyMagickWand leftArm
                LibMagick.destroyMagickWand leftSleeve
                LibMagick.destroyMagickWand leftLeg
                LibMagick.destroyMagickWand leftPantLeg
                LibMagick.destroyMagickWand rightArm
                LibMagick.destroyMagickWand rightSleeve
                LibMagick.destroyMagickWand rightLeg
                LibMagick.destroyMagickWand rightPantLeg
                LibMagick.destroyMagickWand skin
                LibMagick.destroyMagickWand bg_wand
                LibMagick.destroyPixelWand bgp_wand
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    class ResizableSkin < Kemal::Handler
        only ["/mc/images/skin/:name/:size", "/mc/images/skin/:name/:size/true"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            size = env.params.url["size"].nil? ? 85.to_u64 : "#{env.params.url["size"]}".to_u64
            size = size < 16 ? 16.to_u64 : size
            if name.size > 16
                name = "steve"
            end
            name.chars.each do |char|
                if /([A-Z_])/i.match(char.to_s).nil?
                    name = "steve"
                    break
                end
            end
            redisKey = "#{ENV["REDIS_MCPC_SKIN_RENDER"]}#{name}:#{size}:withEverything"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                skin = LibMagick.newMagickWand
                bg_wand = LibMagick.newMagickWand
                bgp_wand = LibMagick.newPixelWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                checkHeight = LibMagick.magickGetImageHeight( skin ) === 32 ? 32 : 64
                # ------------------------------------------------- #
                #          Create transparent 16x32 image.          #
                # ------------------------------------------------- #
                LibMagick.pixelSetColor bgp_wand, "none"
                LibMagick.magickNewImage bg_wand, 16, 32, bgp_wand
                LibMagick.magickSetImageFormat bg_wand, "PNG"
                # ------------------------------------------------- #
                #                Clone skin 12 times                #
                # ------------------------------------------------- #
                head = LibMagick.cloneMagickWand skin
                helmet = LibMagick.cloneMagickWand skin
                chest = LibMagick.cloneMagickWand skin
                jacket = LibMagick.cloneMagickWand skin
                leftArm = LibMagick.cloneMagickWand skin
                leftSleeve = LibMagick.cloneMagickWand skin
                leftLeg = LibMagick.cloneMagickWand skin
                leftPantLeg = LibMagick.cloneMagickWand skin
                rightArm = LibMagick.cloneMagickWand skin
                rightSleeve = LibMagick.cloneMagickWand skin
                rightLeg = LibMagick.cloneMagickWand skin
                rightPantLeg = LibMagick.cloneMagickWand skin
                # ------------------------------------------------- #
                #      Crop images down to singular body parts      #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage helmet, 8, 8, 40, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 44, 20
                    LibMagick.magickCropImage leftLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                else
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage helmet, 8, 8, 40, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage jacket, 8, 12, 20, 36
                    LibMagick.magickCropImage leftArm, 4, 12, 36, 52
                    LibMagick.magickCropImage leftSleeve, 4, 12, 52, 52
                    LibMagick.magickCropImage leftLeg, 4, 12, 20, 52
                    LibMagick.magickCropImage leftPantLeg, 4, 12, 4, 52
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightSleeve, 4, 12, 44, 36
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightPantLeg, 4, 12, 4, 36
                end
                # ------------------------------------------------- #
                #       Merge body parts into the blank image       #
                # ------------------------------------------------- #
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
                if checkHeight === 32
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    if !plainHelmet
                        LibMagick.magickCompositeImage bg_wand, helmet, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    end
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                else
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    if !plainHelmet
                        LibMagick.magickCompositeImage bg_wand, helmet, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    end
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, jacket, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftSleeve, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, leftPantLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightSleeve, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                    LibMagick.magickCompositeImage bg_wand, rightPantLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                end
                # ------------------------------------------------- #
                LibMagick.magickResizeImage bg_wand, size, size * 2, LibMagick::FilterTypes::PointFilter, 0
                buffer = LibMagick.magickGetImageBlob bg_wand, out length
                slice = Slice.new( buffer, length )
                #redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand head
                LibMagick.destroyMagickWand helmet
                LibMagick.destroyMagickWand chest
                LibMagick.destroyMagickWand jacket
                LibMagick.destroyMagickWand leftArm
                LibMagick.destroyMagickWand leftSleeve
                LibMagick.destroyMagickWand leftLeg
                LibMagick.destroyMagickWand leftPantLeg
                LibMagick.destroyMagickWand rightArm
                LibMagick.destroyMagickWand rightSleeve
                LibMagick.destroyMagickWand rightLeg
                LibMagick.destroyMagickWand rightPantLeg
                LibMagick.destroyMagickWand skin
                LibMagick.destroyMagickWand bg_wand
                LibMagick.destroyPixelWand bgp_wand
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    class StandardSkinWithoutHelmet < Kemal::Handler
        only ["/mc/images/skin/:name/false", "/mc/images/skin/:name/helmet"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            if name.size > 16
                name = "steve"
            end
            name.chars.each do |char|
                if /([A-Z_])/i.match(char.to_s).nil?
                    name = "steve"
                    break
                end
            end
            size = 85.to_u64
            redisKey = "#{ENV["REDIS_MCPC_SKIN_RENDER"]}#{name}:#{size}:withoutHelmet"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                skin = LibMagick.newMagickWand
                bg_wand = LibMagick.newMagickWand
                bgp_wand = LibMagick.newPixelWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                checkHeight = LibMagick.magickGetImageHeight( skin ) === 32 ? 32 : 64
                # ------------------------------------------------- #
                #          Create transparent 16x32 image.          #
                # ------------------------------------------------- #
                LibMagick.pixelSetColor bgp_wand, "none"
                LibMagick.magickNewImage bg_wand, 16, 32, bgp_wand
                LibMagick.magickSetImageFormat bg_wand, "PNG"
                # ------------------------------------------------- #
                #                Clone skin 12 times                #
                # ------------------------------------------------- #
                head = LibMagick.cloneMagickWand skin
                chest = LibMagick.cloneMagickWand skin
                jacket = LibMagick.cloneMagickWand skin
                leftArm = LibMagick.cloneMagickWand skin
                leftSleeve = LibMagick.cloneMagickWand skin
                leftLeg = LibMagick.cloneMagickWand skin
                leftPantLeg = LibMagick.cloneMagickWand skin
                rightArm = LibMagick.cloneMagickWand skin
                rightSleeve = LibMagick.cloneMagickWand skin
                rightLeg = LibMagick.cloneMagickWand skin
                rightPantLeg = LibMagick.cloneMagickWand skin
                # ------------------------------------------------- #
                #      Crop images down to singular body parts      #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 44, 20
                    LibMagick.magickCropImage leftLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                else
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage jacket, 8, 12, 20, 36
                    LibMagick.magickCropImage leftArm, 4, 12, 36, 52
                    LibMagick.magickCropImage leftSleeve, 4, 12, 52, 52
                    LibMagick.magickCropImage leftLeg, 4, 12, 20, 52
                    LibMagick.magickCropImage leftPantLeg, 4, 12, 4, 52
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightSleeve, 4, 12, 44, 36
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightPantLeg, 4, 12, 4, 36
                end
                # ------------------------------------------------- #
                #       Merge body parts into the blank image       #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                else
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, jacket, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftSleeve, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, leftPantLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightSleeve, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                    LibMagick.magickCompositeImage bg_wand, rightPantLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                end
                # ------------------------------------------------- #
                LibMagick.magickResizeImage bg_wand, size, size * 2, LibMagick::FilterTypes::PointFilter, 0
                buffer = LibMagick.magickGetImageBlob bg_wand, out length
                slice = Slice.new( buffer, length )
                #redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand head
                LibMagick.destroyMagickWand chest
                LibMagick.destroyMagickWand jacket
                LibMagick.destroyMagickWand leftArm
                LibMagick.destroyMagickWand leftSleeve
                LibMagick.destroyMagickWand leftLeg
                LibMagick.destroyMagickWand leftPantLeg
                LibMagick.destroyMagickWand rightArm
                LibMagick.destroyMagickWand rightSleeve
                LibMagick.destroyMagickWand rightLeg
                LibMagick.destroyMagickWand rightPantLeg
                LibMagick.destroyMagickWand skin
                LibMagick.destroyMagickWand bg_wand
                LibMagick.destroyPixelWand bgp_wand
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    class ResizableSkinWithoutHelmet < Kemal::Handler
        only ["/mc/images/skin/:name/:size/false","/mc/images/skin/:name/:size/helmet"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            size = env.params.url["size"].nil? ? 85.to_u64 : "#{env.params.url["size"]}".to_u64
            size = size < 16 ? 16.to_u64 : size
            if name.size > 16
                name = "steve"
            end
            name.chars.each do |char|
                if /([A-Z_])/i.match(char.to_s).nil?
                    name = "steve"
                    break
                end
            end
            redisKey = "#{ENV["REDIS_MCPC_SKIN_RENDER"]}#{name}:#{size}:withoutHelmet"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                skin = LibMagick.newMagickWand
                bg_wand = LibMagick.newMagickWand
                bgp_wand = LibMagick.newPixelWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                checkHeight = LibMagick.magickGetImageHeight( skin ) === 32 ? 32 : 64
                # ------------------------------------------------- #
                #          Create transparent 16x32 image.          #
                # ------------------------------------------------- #
                LibMagick.pixelSetColor bgp_wand, "none"
                LibMagick.magickNewImage bg_wand, 16, 32, bgp_wand
                LibMagick.magickSetImageFormat bg_wand, "PNG"
                # ------------------------------------------------- #
                #                Clone skin 12 times                #
                # ------------------------------------------------- #
                head = LibMagick.cloneMagickWand skin
                chest = LibMagick.cloneMagickWand skin
                jacket = LibMagick.cloneMagickWand skin
                leftArm = LibMagick.cloneMagickWand skin
                leftSleeve = LibMagick.cloneMagickWand skin
                leftLeg = LibMagick.cloneMagickWand skin
                leftPantLeg = LibMagick.cloneMagickWand skin
                rightArm = LibMagick.cloneMagickWand skin
                rightSleeve = LibMagick.cloneMagickWand skin
                rightLeg = LibMagick.cloneMagickWand skin
                rightPantLeg = LibMagick.cloneMagickWand skin
                # ------------------------------------------------- #
                #      Crop images down to singular body parts      #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 44, 20
                    LibMagick.magickCropImage leftLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                else
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage jacket, 8, 12, 20, 36
                    LibMagick.magickCropImage leftArm, 4, 12, 36, 52
                    LibMagick.magickCropImage leftSleeve, 4, 12, 52, 52
                    LibMagick.magickCropImage leftLeg, 4, 12, 20, 52
                    LibMagick.magickCropImage leftPantLeg, 4, 12, 4, 52
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightSleeve, 4, 12, 44, 36
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightPantLeg, 4, 12, 4, 36
                end
                # ------------------------------------------------- #
                #       Merge body parts into the blank image       #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                else
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, jacket, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftSleeve, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, leftPantLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightSleeve, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                    LibMagick.magickCompositeImage bg_wand, rightPantLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                end
                # ------------------------------------------------- #
                LibMagick.magickResizeImage bg_wand, size, size * 2, LibMagick::FilterTypes::PointFilter, 0
                buffer = LibMagick.magickGetImageBlob bg_wand, out length
                slice = Slice.new( buffer, length )
                #redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand head
                LibMagick.destroyMagickWand chest
                LibMagick.destroyMagickWand jacket
                LibMagick.destroyMagickWand leftArm
                LibMagick.destroyMagickWand leftSleeve
                LibMagick.destroyMagickWand leftLeg
                LibMagick.destroyMagickWand leftPantLeg
                LibMagick.destroyMagickWand rightArm
                LibMagick.destroyMagickWand rightSleeve
                LibMagick.destroyMagickWand rightLeg
                LibMagick.destroyMagickWand rightPantLeg
                LibMagick.destroyMagickWand skin
                LibMagick.destroyMagickWand bg_wand
                LibMagick.destroyPixelWand bgp_wand
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    class StandardSkinWithoutAnything < Kemal::Handler
        only ["/mc/images/skin/:name/all"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            if name.size > 16
                name = "steve"
            end
            name.chars.each do |char|
                if /([A-Z_])/i.match(char.to_s).nil?
                    name = "steve"
                    break
                end
            end
            size = 85.to_u64
            redisKey = "#{ENV["REDIS_MCPC_SKIN_RENDER"]}#{name}:#{size}:withoutAnything"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                skin = LibMagick.newMagickWand
                bg_wand = LibMagick.newMagickWand
                bgp_wand = LibMagick.newPixelWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                checkHeight = LibMagick.magickGetImageHeight( skin ) === 32 ? 32 : 64
                # ------------------------------------------------- #
                #          Create transparent 16x32 image.          #
                # ------------------------------------------------- #
                LibMagick.pixelSetColor bgp_wand, "none"
                LibMagick.magickNewImage bg_wand, 16, 32, bgp_wand
                LibMagick.magickSetImageFormat bg_wand, "PNG"
                # ------------------------------------------------- #
                #                Clone skin 12 times                #
                # ------------------------------------------------- #
                head = LibMagick.cloneMagickWand skin
                chest = LibMagick.cloneMagickWand skin
                leftArm = LibMagick.cloneMagickWand skin
                leftLeg = LibMagick.cloneMagickWand skin
                rightArm = LibMagick.cloneMagickWand skin
                rightLeg = LibMagick.cloneMagickWand skin
                # ------------------------------------------------- #
                #      Crop images down to singular body parts      #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 44, 20
                    LibMagick.magickCropImage leftLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                else
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 36, 52
                    LibMagick.magickCropImage leftLeg, 4, 12, 20, 52
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                end
                # ------------------------------------------------- #
                #       Merge body parts into the blank image       #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                else
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                end
                # ------------------------------------------------- #
                LibMagick.magickResizeImage bg_wand, size, size * 2, LibMagick::FilterTypes::PointFilter, 0
                buffer = LibMagick.magickGetImageBlob bg_wand, out length
                slice = Slice.new( buffer, length )
                #redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand head
                LibMagick.destroyMagickWand chest
                LibMagick.destroyMagickWand leftArm
                LibMagick.destroyMagickWand leftLeg
                LibMagick.destroyMagickWand rightArm
                LibMagick.destroyMagickWand rightLeg
                LibMagick.destroyMagickWand skin
                LibMagick.destroyMagickWand bg_wand
                LibMagick.destroyPixelWand bgp_wand
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    class ResizableSkinWithoutAnything < Kemal::Handler
        only ["/mc/images/skin/:name/:size/all"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            size = env.params.url["size"].nil? ? 85.to_u64 : "#{env.params.url["size"]}".to_u64
            size = size < 16 ? 16.to_u64 : size
            if name.size > 16
                name = "steve"
            end
            name.chars.each do |char|
                if /([A-Z_])/i.match(char.to_s).nil?
                    name = "steve"
                    break
                end
            end
            redisKey = "#{ENV["REDIS_MCPC_SKIN_RENDER"]}#{name}:#{size}:withoutAnything"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                skin = LibMagick.newMagickWand
                bg_wand = LibMagick.newMagickWand
                bgp_wand = LibMagick.newPixelWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                checkHeight = LibMagick.magickGetImageHeight( skin ) === 32 ? 32 : 64
                # ------------------------------------------------- #
                #          Create transparent 16x32 image.          #
                # ------------------------------------------------- #
                LibMagick.pixelSetColor bgp_wand, "none"
                LibMagick.magickNewImage bg_wand, 16, 32, bgp_wand
                LibMagick.magickSetImageFormat bg_wand, "PNG"
                # ------------------------------------------------- #
                #                Clone skin 12 times                #
                # ------------------------------------------------- #
                head = LibMagick.cloneMagickWand skin
                chest = LibMagick.cloneMagickWand skin
                leftArm = LibMagick.cloneMagickWand skin
                leftLeg = LibMagick.cloneMagickWand skin
                rightArm = LibMagick.cloneMagickWand skin
                rightLeg = LibMagick.cloneMagickWand skin
                # ------------------------------------------------- #
                #      Crop images down to singular body parts      #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 44, 20
                    LibMagick.magickCropImage leftLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                else
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 36, 52
                    LibMagick.magickCropImage leftLeg, 4, 12, 20, 52
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                end
                # ------------------------------------------------- #
                #       Merge body parts into the blank image       #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                else
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                end
                # ------------------------------------------------- #
                LibMagick.magickResizeImage bg_wand, size, size * 2, LibMagick::FilterTypes::PointFilter, 0
                buffer = LibMagick.magickGetImageBlob bg_wand, out length
                slice = Slice.new( buffer, length )
                #redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand head
                LibMagick.destroyMagickWand chest
                LibMagick.destroyMagickWand leftArm
                LibMagick.destroyMagickWand leftLeg
                LibMagick.destroyMagickWand rightArm
                LibMagick.destroyMagickWand rightLeg
                LibMagick.destroyMagickWand skin
                LibMagick.destroyMagickWand bg_wand
                LibMagick.destroyPixelWand bgp_wand
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    class StandardSkinWithoutArmor < Kemal::Handler
        only ["/mc/images/skin/:name/armor"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            if name.size > 16
                name = "steve"
            end
            name.chars.each do |char|
                if /([A-Z_])/i.match(char.to_s).nil?
                    name = "steve"
                    break
                end
            end
            size = 85.to_u64
            redisKey = "#{ENV["REDIS_MCPC_SKIN_RENDER"]}#{name}:#{size}:withoutArmor"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                skin = LibMagick.newMagickWand
                bg_wand = LibMagick.newMagickWand
                bgp_wand = LibMagick.newPixelWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                checkHeight = LibMagick.magickGetImageHeight( skin ) === 32 ? 32 : 64
                # ------------------------------------------------- #
                #          Create transparent 16x32 image.          #
                # ------------------------------------------------- #
                LibMagick.pixelSetColor bgp_wand, "none"
                LibMagick.magickNewImage bg_wand, 16, 32, bgp_wand
                LibMagick.magickSetImageFormat bg_wand, "PNG"
                # ------------------------------------------------- #
                #                Clone skin 12 times                #
                # ------------------------------------------------- #
                head = LibMagick.cloneMagickWand skin
                helmet = LibMagick.cloneMagickWand skin
                chest = LibMagick.cloneMagickWand skin
                leftArm = LibMagick.cloneMagickWand skin
                leftLeg = LibMagick.cloneMagickWand skin
                rightArm = LibMagick.cloneMagickWand skin
                rightLeg = LibMagick.cloneMagickWand skin
                # ------------------------------------------------- #
                #      Crop images down to singular body parts      #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage helmet, 8, 8, 40, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 44, 20
                    LibMagick.magickCropImage leftLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                else
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage helmet, 8, 8, 40, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 36, 52
                    LibMagick.magickCropImage leftLeg, 4, 12, 20, 52
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                end
                # ------------------------------------------------- #
                #       Merge body parts into the blank image       #
                # ------------------------------------------------- #
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
                if checkHeight === 32
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    if !plainHelmet
                        LibMagick.magickCompositeImage bg_wand, helmet, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    end
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                else
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    if !plainHelmet
                        LibMagick.magickCompositeImage bg_wand, helmet, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    end
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                end
                # ------------------------------------------------- #
                LibMagick.magickResizeImage bg_wand, size, size * 2, LibMagick::FilterTypes::PointFilter, 0
                buffer = LibMagick.magickGetImageBlob bg_wand, out length
                slice = Slice.new( buffer, length )
                #redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand head
                LibMagick.destroyMagickWand helmet
                LibMagick.destroyMagickWand chest
                LibMagick.destroyMagickWand leftArm
                LibMagick.destroyMagickWand leftLeg
                LibMagick.destroyMagickWand rightArm
                LibMagick.destroyMagickWand rightLeg
                LibMagick.destroyMagickWand skin
                LibMagick.destroyMagickWand bg_wand
                LibMagick.destroyPixelWand bgp_wand
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    class ResizableSkinWithoutArmor < Kemal::Handler
        only ["/mc/images/skin/:name/:size/armor"], "GET"
        def call(env)
            return call_next(env) unless only_match?(env)
            Dotenv.load
            redis = Redis.new(host: "#{ENV["REDIS_HOST"]}")
            env.response.content_type = "image/png"
            name = env.params.url["name"].nil? ? "steve" : "#{env.params.url["name"]}"
            size = env.params.url["size"].nil? ? 85.to_u64 : "#{env.params.url["size"]}".to_u64
            size = size < 16 ? 16.to_u64 : size
            if name.size > 16
                name = "steve"
            end
            name.chars.each do |char|
                if /([A-Z_])/i.match(char.to_s).nil?
                    name = "steve"
                    break
                end
            end
            redisKey = "#{ENV["REDIS_MCPC_SKIN_RENDER"]}#{name}:#{size}:withoutArmor"
            if redis.exists(redisKey) === 1
                env.response.write(Base64.decode_string(redis.get(redisKey).to_s).to_slice)
            else
                LibMagick.magickWandGenesis
                skin = LibMagick.newMagickWand
                bg_wand = LibMagick.newMagickWand
                bgp_wand = LibMagick.newPixelWand
                if !LibMagick.magickReadImage( skin, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
                    LibMagick.magickReadImage( skin, "http://assets.mojang.com/SkinTemplates/steve.png")
                end
                checkHeight = LibMagick.magickGetImageHeight( skin ) === 32 ? 32 : 64
                # ------------------------------------------------- #
                #          Create transparent 16x32 image.          #
                # ------------------------------------------------- #
                LibMagick.pixelSetColor bgp_wand, "none"
                LibMagick.magickNewImage bg_wand, 16, 32, bgp_wand
                LibMagick.magickSetImageFormat bg_wand, "PNG"
                # ------------------------------------------------- #
                #                Clone skin 12 times                #
                # ------------------------------------------------- #
                head = LibMagick.cloneMagickWand skin
                helmet = LibMagick.cloneMagickWand skin
                chest = LibMagick.cloneMagickWand skin
                leftArm = LibMagick.cloneMagickWand skin
                leftLeg = LibMagick.cloneMagickWand skin
                rightArm = LibMagick.cloneMagickWand skin
                rightLeg = LibMagick.cloneMagickWand skin
                # ------------------------------------------------- #
                #      Crop images down to singular body parts      #
                # ------------------------------------------------- #
                if checkHeight === 32
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage helmet, 8, 8, 40, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 44, 20
                    LibMagick.magickCropImage leftLeg, 4, 12, 4, 20
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                else
                    LibMagick.magickCropImage head, 8, 8, 8, 8
                    LibMagick.magickCropImage helmet, 8, 8, 40, 8
                    LibMagick.magickCropImage chest, 8, 12, 20, 20
                    LibMagick.magickCropImage leftArm, 4, 12, 36, 52
                    LibMagick.magickCropImage leftLeg, 4, 12, 20, 52
                    LibMagick.magickCropImage rightArm, 4, 12, 44, 20
                    LibMagick.magickCropImage rightLeg, 4, 12, 4, 20
                end
                # ------------------------------------------------- #
                #       Merge body parts into the blank image       #
                # ------------------------------------------------- #
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
                if checkHeight === 32
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    if !plainHelmet
                        LibMagick.magickCompositeImage bg_wand, helmet, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    end
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                else
                    LibMagick.magickCompositeImage bg_wand, head, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    if !plainHelmet
                        LibMagick.magickCompositeImage bg_wand, helmet, LibMagick::CompositeOperator::OverCompositeOp, 4, 0
                    end
                    LibMagick.magickCompositeImage bg_wand, chest, LibMagick::CompositeOperator::OverCompositeOp, 4, 8
                    LibMagick.magickCompositeImage bg_wand, leftArm, LibMagick::CompositeOperator::OverCompositeOp, 12, 8
                    LibMagick.magickCompositeImage bg_wand, leftLeg, LibMagick::CompositeOperator::OverCompositeOp, 8, 20
                    LibMagick.magickCompositeImage bg_wand, rightArm, LibMagick::CompositeOperator::OverCompositeOp, 0, 8
                    LibMagick.magickCompositeImage bg_wand, rightLeg, LibMagick::CompositeOperator::OverCompositeOp, 4, 20
                end
                # ------------------------------------------------- #
                LibMagick.magickResizeImage bg_wand, size, size * 2, LibMagick::FilterTypes::PointFilter, 0
                buffer = LibMagick.magickGetImageBlob bg_wand, out length
                slice = Slice.new( buffer, length )
                #redis.set(redisKey, Base64.encode(String.new(slice)), 120)
                env.response.write(slice)
                LibMagick.destroyMagickWand head
                LibMagick.destroyMagickWand helmet
                LibMagick.destroyMagickWand chest
                LibMagick.destroyMagickWand leftArm
                LibMagick.destroyMagickWand leftLeg
                LibMagick.destroyMagickWand rightArm
                LibMagick.destroyMagickWand rightLeg
                LibMagick.destroyMagickWand skin
                LibMagick.destroyMagickWand bg_wand
                LibMagick.destroyPixelWand bgp_wand
                LibMagick.magickWandTerminus
            end
            redis.close
        end
    end
    add_handler StandardSkin.new
    add_handler StandardSkinWithoutHelmet.new
    add_handler StandardSkinWithoutArmor.new
    add_handler StandardSkinWithoutAnything.new
    add_handler ResizableSkin.new
    add_handler ResizableSkinWithoutHelmet.new
    add_handler ResizableSkinWithoutArmor.new
    add_handler ResizableSkinWithoutAnything.new
end