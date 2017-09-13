## Alpha 1.1.2:

### September 9th 2017 - September 15th 2017
- All of the updates released in September are dedicated to my cat who was put down on September 11th after living for over 14 years, I hope one day I'll be reunited with him <3. I hope once I am reunited with him, that we both remember each other. He'll always be in my heart <3

#### Added
- Added support for the following games:
  - Quake 2
  - Quake 3
  - Quake Live
- Documentation for All-Seeing Eye
- Protocol documentation listings

#### Changes
- Switched over to using a darker theme (Developers prefer working at night)

#### Fixes
- Fixed hostnames returning as null for All-Seeing Eye tests

## Alpha 1.1.1:

### September 4th 2017 - September 8th 2017
- All of the updates released in September are dedicated to my cat who was put down on September 11th after living for over 14 years, I hope one day I'll be reunited with him <3. I hope once I am reunited with him, that we both remember each other. He'll always be in my heart <3

#### Added
- Added support for the following games:
  - Call of Duty
  - Call of Duty: United Offensive
  - Call of Duty 2
  - Call of Duty 4
  - Call of Duty: World at War
  - Call of Duty: Modern Warfare 3
- Added base query protocol support:
  - Gamespy
  - Gamespy 2
  - Gamespy 3
  - All-Seeing Eye
  - Source

#### Fixed
- Battlefield series player list not returning anything.
- Battlefield Hardline not working at all.

## Alpha 1.1.0:

### August 23rd 2017 - September 4th 2017
- All of the updates released in September are dedicated to my cat who was put down on September 11th after living for over 14 years, I hope one day I'll be reunited with him <3. I hope once I am reunited with him, that we both remember each other. He'll always be in my heart <3

#### Added
- Protocol output to determine if the request is udp or tcp.
- IP Filtering
- Debug function to each API
- Attempt for querying servers which provide the query port instead of the join port.
- Error codes
- Make use of the ternary operator.
- Added support for the following games:
  - ARMA3
  - BRINK
  - Conan Exiles
  - Dark and Light
  - DayZ Standalone
  - Rust

#### Changes
- IP & Port parameters are now separated.
- Simplified error messages.
- Cleaned up redis related lines.
- Protocol is no longer a number, instead it's been replaced with either tcp or udp.
- Github link now goes to the issue tracker.
- Documentation links now cover the image along with the button.

#### Fixed
- MCPE redis entries were using MCPC's key structure.
- Finally fixed the null bug on failed queries. Should of fixed it long ago.

#### Removed
- Removed Battlefield: Bad Company 2 from the documentation list, full removal of the API might happen in a year if requests are non existent.
- Removed WIP support for Arma2, couldn't get a positive response from any server listed on Gametracker.