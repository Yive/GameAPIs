## Alpha 1.1.0:

### August 23rd 2017 - September 4th 2017

#### Added
- Protocol output to determine if the request is udp or tcp.
- IP Filtering
- Debug function to each API (Only accessible by Yive.)
- Attempt for querying servers which provide the query port instead of the join port.
- Error codes
- Make use of the ternary operator.
- Added support for the following games:
  - ARMA3
  - BRINK
  - Conan Exiles
  - Dark And Light
  - DayZ Standalone
  - Rust

#### Changes
- IP & Port parameters are now separated.
- Simplified error messages.
- Cleaned up redis related lines.
- Protocol is no longer a number, instead it's been replaced with either tcp or udp.

#### Fixed
- MCPE redis entries were using MCPC's key structure.
- Finally fixed the null bug on failed queries. Should of fixed it long ago.

#### Removed
- Removed Battlefield: Bad Company 2 from the documentation list, full removal of the API might happen in a year if requests are non existent.
- Removed WIP support for Arma2, couldn't get a positive response from any server listed on Gametracker.