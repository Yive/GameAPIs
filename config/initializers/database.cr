require "granite_orm/adapter/sqlite"

Granite::ORM.settings.database_url = Amber.settings.database_url
Granite::ORM.settings.logger = Amber.settings.logger

