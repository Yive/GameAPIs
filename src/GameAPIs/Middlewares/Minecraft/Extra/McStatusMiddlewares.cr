module GameAPIs
    class AllStatuses < Kemal::Handler
        only ["/mc/extra/mcstatus"], "GET"
        def call(env)
            mcStatus = Cossack.get("https://status.mojang.com/check")
            mcStatusJson = JSON.parse(mcStatus.body)
        end
    end
    add_handler AllStatuses.new
end