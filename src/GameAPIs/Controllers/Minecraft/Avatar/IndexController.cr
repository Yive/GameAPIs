module GameAPIs
    get "/mc/images/avatar/:name/:size" do |env|
        env.response.content_type = "image/png"
        LibMagick.magickWandGenesis
        wand = LibMagick.newMagickWand
        name = env.params["name"].nil? ? "steve" : env.params["name"]
        size = env.params["size"].nil? ? 100.to_u64 : "#{env.params["size"]}".to_u64
        if LibMagick.magickReadImage( wand, "http://skins.minecraft.net/MinecraftSkins/#{name}.png")
            wand2 = LibMagick.cloneMagickWand wand
            LibMagick.magickCropImage wand2, 8, 8, 40, 8
            LibMagick.magickCropImage wand, 8, 8, 8, 8
            # TODO find method to check if the helmet is a solid colour.
            LibMagick.magickCompositeImage wand, wand2, LibMagick::CompositeOperator::OverCompositeOp, 0, 0
            LibMagick.magickScaleImage wand, size, size
            buffer = LibMagick.magickGetImageBlob wand, out length
            slice = Slice.new( buffer, length )
            env.response.write(slice)
        end
        LibMagick.destroyMagickWand wand
        LibMagick.destroyMagickWand wand2
        LibMagick.magickWandTerminus
    end
end
