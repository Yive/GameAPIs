## Alpha 1.1.1:

### September 4th 2017 - September __ 2017

#### Added
- Added support for the following games:
  - Call of Duty
  - Call of Duty: United Offensive
  - Call of Duty 2
  - Call of Duty 4
  - Call of Duty: World at War
  - Call of Duty: Modern Warfare 3
- Added base query protocol support:
  - Quake 2
  - Quake 3
  - Gamespy
  - Gamespy 2
  - Gamespy 3
  - All-Seeing Eye
  - Source

#### Changes
- IP & Port parameters are now separated.
- Simplified error messages.
- Cleaned up redis related lines.
- Protocol is no longer a number, instead it's been replaced with either tcp or udp.

#### Fixed
- Battlefield series player list not returning anything.
- Battlefield Hardline not working at all.

## Alpha 1.1.0:

### August 23rd 2017 - September 4th 2017

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