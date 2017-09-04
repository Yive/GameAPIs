## Alpha 1.1.0:

### August 23rd 2017 - September __ 2017

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
  - DayZ Standalone
  - Rust

#### Changes
- IP & Port parameters are now separated.
- Simplified error messages.
- Cleaned up redis related lines.
- Protocol is no longer a number, instead it's been replaced with either tcp or udp.

#### Fixed
- MCPE redis entries were using MCPC's key structure.

#### Removed
- Removed documentation for Battlefield: Bad Company 2, removal of the API might happen in 365 days, but unlikely.
- Removed up coming support for Arma2, couldn't get a positive response from any server listed on Gametracker.
