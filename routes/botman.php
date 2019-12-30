<?php

use App\Http\Controllers\BotManController;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Log;
use KubAT\PhpSimple\HtmlDomParser;


const MENU = [
    "player_type" => [
        ["value" => "ANY", "title" => "Any"],
        ["value" => "PLY", "title" => "Playmaker"],
        ["value" => "PWF", "title" => "Power Forward"],
        ["value" => "TWF", "title" => "Two-Way Forward"],
        ["value" => "TWD", "title" => "Two-Way Defensemen"],
        ["value" => "OFD", "title" => "Offenive Defensemen"],
        ["value" => "SNP", "title" => "Sniper"],
        ["value" => "DFD", "title" => "Defensive Defesemen"],
        ["value" => "GRN", "title" => "Grinder"],
        ["value" => "ENF", "title" => "Enforcer"],
    ],
    "card_type" => [
        ["value" => "ANY", "title" => "Any"],
        ["value" => "BASE", "title" => "Base"],
        ["value" => "CLAS", "title" => "Classic NHL"],
        ["value" => "COVR", "title" => "Cover Athlete"],
        ["value" => "DYND", "title" => "Dynamic Duo"],
        ["value" => "FANT", "title" => "Fantasy Hockey"],
        ["value" => "GLOB", "title" => "Global Series"],
        ["value" => "HH", "title" => "Heavy Hitters"],
        ["value" => "HOME", "title" => "Hometown Hero"],
        ["value" => "ICON", "title" => "Icons"],
        ["value" => "LDR", "title" => "Leader"],
        ["value" => "MICO", "title" => "Master Icons"],
        ["value" => "MSP", "title" => "Master Set Player"],
        ["value" => "PT", "title" => "Prime Time"],
        ["value" => "TOTW", "title" => "Team of the Week"],
        ["value" => "WC", "title" => "Winter Classic"],
        ["value" => "WIN", "title" => "Winternational"],
        ["value" => "YS", "title" => "Young Stars"],
    ],
    "synergy" => [
        ["value" => "ANY", "title" => "Any"],
        ["value" => "AD", "title" => "AD - Arm Day"],
        ["value" => "BM", "title" => "BM - Breakout Master"],
        ["value" => "CP", "title" => "CP - Clutch Player"],
        ["value" => "DZ", "title" => "DZ - Dangler Zone"],
        ["value" => "DK", "title" => "DK - Do Your Dekes"],
        ["value" => "FB", "title" => "FB - For the Boys"],
        ["value" => "HT", "title" => "HT - Hammer Time"],
        ["value" => "HH", "title" => "HH - Heavy Hitters"],
        ["value" => "BL", "title" => "BL - Hold the Blue Line"],
        ["value" => "M", "title" => "M - Magician"],
        ["value" => "NP", "title" => "NP - Net Front Presence"],
        ["value" => "1T", "title" => "1T - One-Timer Efficiency"],
        ["value" => "RS", "title" => "RS - Rock Solid"],
        ["value" => "SP", "title" => "SP - Sustained Pressure"],
        ["value" => "TK", "title" => "TK - Takeaway Kings"],
        ["value" => "TN", "title" => "TN - Thread the Needle"],
        ["value" => "WM", "title" => "WM - Wingman"],
        ["value" => "WK", "title" => "WK - Workhorse"],
        ["value" => "WC", "title" => "WC - Wrecking Crew"],
        ["value" => "X", "title" => "X - X-Factor"],


    ],
    "league" => [
        ["value" => "ANY", "title" => "All"],
        ["value" => "NHL", "title" => "NHL"],
        ["value" => "NHLAA", "title" => "NHLAA"],
        ["value" => "AHL", "title" => "AHL"],
        ["value" => "SHL", "title" => "SHL"],
        ["value" => "Liiga", "title" => "Liiga"],
        ["value" => "DEL", "title" => "DEL"],
        ["value" => "ELH", "title" => "ELH"],
        ["value" => "NL", "title" => "NL"],
        ["value" => "EBEL", "title" => "EBEL"],
        ["value" => "HA", "title" => "HA"],
        ["value" => "CHL", "title" => "CHL"],
        ["value" => "INT", "title" => "INT"],
        ["value" => "OHL", "title" => "OHL"],
        ["value" => "QMJHL", "title" => "QMJHL"],
        ["value" => "WHL", "title" => "WHL"],
        ["value" => "ECHL", "title" => "ECHL"],
        ["value" => "EAS", "title" => "EAS"],
    ],
    "all_teams" => [
        ["league" => "NHL", "value" => "ANA", "text" => "Anaheim Ducks"],
        ["league" => "NHL", "value" => "ARZ", "text" => "Arizona Coyotes"],
        ["league" => "NHL", "value" => "NHLA", "text" => "Atlantic All-Stars"],
        ["league" => "NHL", "value" => "BOS", "text" => "Boston Bruins"],
        ["league" => "NHL", "value" => "BUF", "text" => "Buffalo Sabres"],
        ["league" => "NHL", "value" => "CGY", "text" => "Calgary Flames"],
        ["league" => "NHL", "value" => "CAR", "text" => "Carolina Hurricanes"],
        ["league" => "NHL", "value" => "CHI", "text" => "Chicago Blackhawks"],
        ["league" => "NHL", "value" => "COL", "text" => "Colorado Avalanche"],
        ["league" => "NHL", "value" => "CBJ", "text" => "Columbus Blue Jackets"],
        ["league" => "NHL", "value" => "DAL", "text" => "Dallas Stars"],
        ["league" => "NHL", "value" => "DET", "text" => "Detroit Red Wings"],
        ["league" => "NHL", "value" => "EDM", "text" => "Edmonton Oilers"],
        ["league" => "NHL", "value" => "FLA", "text" => "Florida Panthers"],
        ["league" => "NHL", "value" => "HAR", "text" => "Hartford Whalers"],
        ["league" => "NHL", "value" => "LAK", "text" => "Los Angeles Kings"],
        ["league" => "NHL", "value" => "MNS", "text" => "Minnesota North Stars"],
        ["league" => "NHL", "value" => "MIN", "text" => "Minnesota Wild"],
        ["league" => "NHL", "value" => "MTL", "text" => "Montreal Canadiens"],
        ["league" => "NHL", "value" => "NSH", "text" => "Nashville Predators"],
        ["league" => "NHL", "value" => "NJD", "text" => "New Jersey Devils"],
        ["league" => "NHL", "value" => "NYI", "text" => "New York Islanders"],
        ["league" => "NHL", "value" => "NYR", "text" => "New York Rangers"],
        ["league" => "NHL", "value" => "FA", "text" => "NHL Free Agents"],
        ["league" => "NHL", "value" => "OTT", "text" => "Ottawa Senators"],
        ["league" => "NHL", "value" => "NHLP", "text" => "Pacific All-Stars"],
        ["league" => "NHL", "value" => "PHI", "text" => "Philadelphia Flyers"],
        ["league" => "NHL", "value" => "PIT", "text" => "Pittsburgh Penguins"],
        ["league" => "NHL", "value" => "QC", "text" => "Quebec Nordiques"],
        ["league" => "NHL", "value" => "SJS", "text" => "San Jose Sharks"],
        ["league" => "NHL", "value" => "STL", "text" => "St. Louis Blues"],
        ["league" => "NHL", "value" => "TBL", "text" => "Tampa Bay Lightning"],
        ["league" => "NHL", "value" => "TOR", "text" => "Toronto Maple Leafs"],
        ["league" => "NHL", "value" => "VAN", "text" => "Vancouver Canucks"],
        ["league" => "NHL", "value" => "VGK", "text" => "Vegas Golden Knights"],
        ["league" => "NHL", "value" => "WSH", "text" => "Washington Capitals"],
        ["league" => "NHL", "value" => "WPG", "text" => "Winnipeg Jets"],
        ["league" => "AHL", "value" => "BAK", "text" => "Bakersfield Condors"],
        ["league" => "AHL", "value" => "BES", "text" => "Belleville Senators"],
        ["league" => "AHL", "value" => "BID", "text" => "Binghamton Devils"],
        ["league" => "AHL", "value" => "BIN", "text" => "Binghamton Senators"],
        ["league" => "AHL", "value" => "BRI", "text" => "Bridgeport Sound Tigers"],
        ["league" => "AHL", "value" => "CHA", "text" => "Charlotte Checkers"],
        ["league" => "AHL", "value" => "CHW", "text" => "Chicago Wolves"],
        ["league" => "AHL", "value" => "CLE", "text" => "Cleveland Monsters"],
        ["league" => "AHL", "value" => "COL", "text" => "Colorado Eagles"],
        ["league" => "AHL", "value" => "GRA", "text" => "Grand Rapids Griffins"],
        ["league" => "AHL", "value" => "HAR", "text" => "Hartford Wolf Pack"],
        ["league" => "AHL", "value" => "HER", "text" => "Hershey Bears"],
        ["league" => "AHL", "value" => "IOW", "text" => "Iowa Wild"],
        ["league" => "AHL", "value" => "LAV", "text" => "Laval Rockets"],
        ["league" => "AHL", "value" => "LEH", "text" => "Lehigh Valley Phantoms"],
        ["league" => "AHL", "value" => "MAN", "text" => "Manitoba Moose"],
        ["league" => "AHL", "value" => "MIL", "text" => "Milwaukee Admirals"],
        ["league" => "AHL", "value" => "ONT", "text" => "Ontario Reign"],
        ["league" => "AHL", "value" => "PRO", "text" => "Providence Bruins"],
        ["league" => "AHL", "value" => "RCH", "text" => "Rochester Americans"],
        ["league" => "AHL", "value" => "ROC", "text" => "Rockford IceHogs"],
        ["league" => "AHL", "value" => "SAR", "text" => "San Antonio Rampage"],
        ["league" => "AHL", "value" => "SDG", "text" => "San Diego Gulls"],
        ["league" => "AHL", "value" => "SJB", "text" => "San Jose Barracuda"],
        ["league" => "AHL", "value" => "SPT", "text" => "Springfield Thunderbirds"],
        ["league" => "AHL", "value" => "STO", "text" => "Stockton Heat"],
        ["league" => "AHL", "value" => "SYR", "text" => "Syracuse Crunch"],
        ["league" => "AHL", "value" => "TEX", "text" => "Texas Stars"],
        ["league" => "AHL", "value" => "TOR", "text" => "Toronto Marlies"],
        ["league" => "AHL", "value" => "TUC", "text" => "Tucson Roadrunners"],
        ["league" => "AHL", "value" => "UTI", "text" => "Utica Comets"],
        ["league" => "AHL", "value" => "WBS", "text" => "Wilkes-Barre/Scranton Penguins"],
        ["league" => "ECHL", "value" => "ADT", "text" => "Adirondack Thunder"],
        ["league" => "ECHL", "value" => "ALL", "text" => "Allen Americans"],
        ["league" => "ECHL", "value" => "ATL", "text" => "Atlanta Gladiators"],
        ["league" => "ECHL", "value" => "BRA", "text" => "Brampton Beast"],
        ["league" => "ECHL", "value" => "CIN", "text" => "Cincinnati Cyclones"],
        ["league" => "ECHL", "value" => "FLA", "text" => "Florida Everblades"],
        ["league" => "ECHL", "value" => "FWK", "text" => "Fort Wayne Komets"],
        ["league" => "ECHL", "value" => "GRE", "text" => "Greenville Swamp Rabbits"],
        ["league" => "ECHL", "value" => "IDS", "text" => "Idaho Steelheads"],
        ["league" => "ECHL", "value" => "IND", "text" => "Indy Fuel"],
        ["league" => "ECHL", "value" => "JAC", "text" => "Jacksonville IceMen"],
        ["league" => "ECHL", "value" => "KAL", "text" => "Kalamazoo Wings"],
        ["league" => "ECHL", "value" => "KC", "text" => "Kansas City Mavericks"],
        ["league" => "ECHL", "value" => "MAI", "text" => "Maine Mariners"],
        ["league" => "ECHL", "value" => "NFLD", "text" => "Newfoundland Growlers"],
        ["league" => "ECHL", "value" => "NOR", "text" => "Norfolk Admirals"],
        ["league" => "ECHL", "value" => "ORL", "text" => "Orlando Solar Bears"],
        ["league" => "ECHL", "value" => "RAP", "text" => "Rapid City Rush"],
        ["league" => "ECHL", "value" => "REA", "text" => "Reading Royals"],
        ["league" => "ECHL", "value" => "SCS", "text" => "South Carolina Stingrays"],
        ["league" => "ECHL", "value" => "TOL", "text" => "Toledo Walleye"],
        ["league" => "ECHL", "value" => "TUL", "text" => "Tulsa Oilers"],
        ["league" => "ECHL", "value" => "UTA", "text" => "Utah Grizzlies"],
        ["league" => "ECHL", "value" => "WHE", "text" => "Wheeling Nailers"],
        ["league" => "ECHL", "value" => "WIC", "text" => "Wichita Thunder"],
        ["league" => "ECHL", "value" => "WOR", "text" => "Worcester Railers"],
        ["league" => "OHL", "value" => "BAR", "text" => "Barrie Colts"],
        ["league" => "OHL", "value" => "ERE", "text" => "Erie Otters"],
        ["league" => "OHL", "value" => "FLI", "text" => "Flint Firebirds"],
        ["league" => "OHL", "value" => "GUE", "text" => "Guelph Storm"],
        ["league" => "OHL", "value" => "HAM", "text" => "Hamilton Bulldogs"],
        ["league" => "OHL", "value" => "KIN", "text" => "Kingston Frontenacs"],
        ["league" => "OHL", "value" => "KIT", "text" => "Kitchener Rangers"],
        ["league" => "OHL", "value" => "LON", "text" => "London Knights"],
        ["league" => "OHL", "value" => "MIS", "text" => "Mississauga Steelheads"],
        ["league" => "OHL", "value" => "NIA", "text" => "Niagara IceDogs"],
        ["league" => "OHL", "value" => "NOB", "text" => "North Bay Battalion"],
        ["league" => "OHL", "value" => "OSH", "text" => "Oshawa Generals"],
        ["league" => "OHL", "value" => "OTT", "text" => "Ottawa 67's"],
        ["league" => "OHL", "value" => "OWE", "text" => "Owen Sound Attack"],
        ["league" => "OHL", "value" => "PET", "text" => "Peterborough Petes"],
        ["league" => "OHL", "value" => "SAG", "text" => "Saginaw Spirit"],
        ["league" => "OHL", "value" => "SAR", "text" => "Sarnia Sting"],
        ["league" => "OHL", "value" => "SSM", "text" => "Sault Ste. Marie Greyhounds"],
        ["league" => "OHL", "value" => "SUD", "text" => "Sudbury Wolves"],
        ["league" => "OHL", "value" => "WIN", "text" => "Windsor Spitfires"],
        ["league" => "QMJHL", "value" => "ACA", "text" => "Acadie-Bathurst Titan"],
        ["league" => "QMJHL", "value" => "BAI", "text" => "Baie-Comeau Drakkar"],
        ["league" => "QMJHL", "value" => "BLA", "text" => "Blainville-Boisbriand Armada"],
        ["league" => "QMJHL", "value" => "CB", "text" => "Cape Breton Screaming Eagles"],
        ["league" => "QMJHL", "value" => "CHR", "text" => "Charlottetown Islanders"],
        ["league" => "QMJHL", "value" => "CHC", "text" => "Chicoutimi Sagueneens"],
        ["league" => "QMJHL", "value" => "DRU", "text" => "Drummondville Voltigeurs"],
        ["league" => "QMJHL", "value" => "GAT", "text" => "Gatineau Olympiques"],
        ["league" => "QMJHL", "value" => "HFX", "text" => "Halifax Mooseheads"],
        ["league" => "QMJHL", "value" => "MON", "text" => "Moncton Wildcats"],
        ["league" => "QMJHL", "value" => "QUE", "text" => "Quebec Remparts"],
        ["league" => "QMJHL", "value" => "RIM", "text" => "Rimouski Oceanic"],
        ["league" => "QMJHL", "value" => "ROU", "text" => "Rouyn-Noranda Huskies"],
        ["league" => "QMJHL", "value" => "STJ", "text" => "Saint John Sea Dogs"],
        ["league" => "QMJHL", "value" => "SHA", "text" => "Shawinigan Cataractes"],
        ["league" => "QMJHL", "value" => "SHE", "text" => "Sherbrooke Phoenix"],
        ["league" => "QMJHL", "value" => "VAL", "text" => "Val-D'Or Foreurs"],
        ["league" => "QMJHL", "value" => "VIC", "text" => "Victoriaville Tigres"],
        ["league" => "WHL", "value" => "BRA", "text" => "Brandon Wheat Kings"],
        ["league" => "WHL", "value" => "CGY", "text" => "Calgary Hitmen"],
        ["league" => "WHL", "value" => "EDM", "text" => "Edmonton Oil Kings"],
        ["league" => "WHL", "value" => "EVE", "text" => "Everett Silvertips"],
        ["league" => "WHL", "value" => "KAM", "text" => "Kamloops Blazers"],
        ["league" => "WHL", "value" => "KEL", "text" => "Kelowna Rockets"],
        ["league" => "WHL", "value" => "LET", "text" => "Lethbridge Hurricanes"],
        ["league" => "WHL", "value" => "MED", "text" => "Medicine Hat Tigers"],
        ["league" => "WHL", "value" => "MOO", "text" => "Moose Jaw Warriors"],
        ["league" => "WHL", "value" => "POR", "text" => "Portland Winter Hawks"],
        ["league" => "WHL", "value" => "PRA", "text" => "Prince Albert Raiders"],
        ["league" => "WHL", "value" => "PRG", "text" => "Prince George Cougars"],
        ["league" => "WHL", "value" => "RED", "text" => "Red Deer Rebels"],
        ["league" => "WHL", "value" => "REG", "text" => "Regina Pats"],
        ["league" => "WHL", "value" => "SAS", "text" => "Saskatoon Blades"],
        ["league" => "WHL", "value" => "SEA", "text" => "Seattle Thunderbirds"],
        ["league" => "WHL", "value" => "SPO", "text" => "Spokane Chiefs"],
        ["league" => "WHL", "value" => "SWC", "text" => "Swift Current Broncos"],
        ["league" => "WHL", "value" => "TRI", "text" => "Tri-City Americans"],
        ["league" => "WHL", "value" => "VAN", "text" => "Vancouver Giants"],
        ["league" => "WHL", "value" => "VIC", "text" => "Victoria Royals"],
        ["league" => "WHL", "value" => "WPI", "text" => "Winnipeg Ice"],
        ["league" => "SHL", "value" => "BRY", "text" => "Brynas IF"],
        ["league" => "SHL", "value" => "DJU", "text" => "Djugardens Hockey"],
        ["league" => "SHL", "value" => "FAR", "text" => "Farjestad BK"],
        ["league" => "SHL", "value" => "FRO", "text" => "Frolunda Indians"],
        ["league" => "SHL", "value" => "HV", "text" => "HV71"],
        ["league" => "SHL", "value" => "OSK", "text" => "IK Oskarshamn"],
        ["league" => "SHL", "value" => "LEK", "text" => "Leksands IF"],
        ["league" => "SHL", "value" => "LIN", "text" => "Linkopings HC"],
        ["league" => "SHL", "value" => "LUL", "text" => "Lulea Hockey"],
        ["league" => "SHL", "value" => "MAL", "text" => "Malmo Redhawks"],
        ["league" => "SHL", "value" => "ORE", "text" => "Orebro Hockey"],
        ["league" => "SHL", "value" => "ROG", "text" => "Rogle BK"],
        ["league" => "SHL", "value" => "SKE", "text" => "Skelleftea AK"],
        ["league" => "SHL", "value" => "VAX", "text" => "Vaxjo Lakers"],
        ["league" => "Liiga", "value" => "HEL", "text" => "Helsingin IFK"],
        ["league" => "Liiga", "value" => "HAM", "text" => "HPK Hameenlinna"],
        ["league" => "Liiga", "value" => "JYV", "text" => "JYP Jyvaskyla"],
        ["league" => "Liiga", "value" => "KAL", "text" => "KalPa Kuopio"],
        ["league" => "Liiga", "value" => "KOO", "text" => "KooKoo Kouvala"],
        ["league" => "Liiga", "value" => "MIK", "text" => "Mikkelin Jukurit"],
        ["league" => "Liiga", "value" => "OUL", "text" => "Oulun Karpat"],
        ["league" => "Liiga", "value" => "LAH", "text" => "Pelicans Lahti"],
        ["league" => "Liiga", "value" => "POA", "text" => "Porin Assat"],
        ["league" => "Liiga", "value" => "RAU", "text" => "Rauman Lukko"],
        ["league" => "Liiga", "value" => "LAP", "text" => "SaiPa Lappeenranta"],
        ["league" => "Liiga", "value" => "TAI", "text" => "Tampereen Ilves"],
        ["league" => "Liiga", "value" => "TAT", "text" => "Tampereen Tappara"],
        ["league" => "Liiga", "value" => "TUR", "text" => "TPS Turku"],
        ["league" => "Liiga", "value" => "VAA", "text" => "Vaasan Sport"],
        ["league" => "NL", "value" => "EHC", "text" => "EHC Biel"],
        ["league" => "NL", "value" => "EV", "text" => "EV Zug"],
        ["league" => "NL", "value" => "GES", "text" => "Geneve-Servette HC"],
        ["league" => "NL", "value" => "AMP", "text" => "HC Ambri-Piotta"],
        ["league" => "NL", "value" => "DAV", "text" => "HC Davos"],
        ["league" => "NL", "value" => "FRG", "text" => "HC Fribourg-Gotteron"],
        ["league" => "NL", "value" => "LAU", "text" => "HC Lausanne"],
        ["league" => "NL", "value" => "LUG", "text" => "HC Lugano"],
        ["league" => "NL", "value" => "RAJ", "text" => "Rapperswil-Jona Lakers"],
        ["league" => "NL", "value" => "BER", "text" => "SC Bern"],
        ["league" => "NL", "value" => "SCL", "text" => "SCL Tigers"],
        ["league" => "NL", "value" => "ZSC", "text" => "ZSC Lions"],
        ["league" => "DEL", "value" => "ADL", "text" => "Adler Mannheim"],
        ["league" => "DEL", "value" => "AUG", "text" => "Augsburger Panther"],
        ["league" => "DEL", "value" => "DUS", "text" => "Dusseldorfer EG"],
        ["league" => "DEL", "value" => "MUN", "text" => "EHC Munchen"],
        ["league" => "DEL", "value" => "BER", "text" => "Eisbaren Berlin"],
        ["league" => "DEL", "value" => "ING", "text" => "ERC Ingolstadt"],
        ["league" => "DEL", "value" => "FIP", "text" => "Fischtown Pinguins"],
        ["league" => "DEL", "value" => "WOL", "text" => "Grizzly Adams Wolfsburg"],
        ["league" => "DEL", "value" => "ISE", "text" => "Iserlohn Roosters"],
        ["league" => "DEL", "value" => "KOL", "text" => "Kolner Haie"],
        ["league" => "DEL", "value" => "KRE", "text" => "Krefeld Pinguine"],
        ["league" => "DEL", "value" => "SWW", "text" => "Schwenninger Wild Wings"],
        ["league" => "DEL", "value" => "STR", "text" => "Straubing Tigers"],
        ["league" => "DEL", "value" => "THO", "text" => "Thomas Sabo Ice Tigers"],
        ["league" => "EBEL", "value" => "LBW", "text" => "Black Wings Linz"],
        ["league" => "EBEL", "value" => "DOB", "text" => "Dornbirner EC"],
        ["league" => "EBEL", "value" => "KAC", "text" => "EC KAC"],
        ["league" => "EBEL", "value" => "VSV", "text" => "EC VSV"],
        ["league" => "EBEL", "value" => "MMG", "text" => "Graz 99ers"],
        ["league" => "EBEL", "value" => "TWK", "text" => "HC TWK Innsbruck"],
        ["league" => "EBEL", "value" => "SUD", "text" => "HCB Sudtirol Alperia"],
        ["league" => "EBEL", "value" => "ORZ", "text" => "Orli Znojmo"],
        ["league" => "EBEL", "value" => "RBS", "text" => "Red Bull Salzburg"],
        ["league" => "EBEL", "value" => "FEH", "text" => "SAPA Fehervar AV 19"],
        ["league" => "EBEL", "value" => "VIE", "text" => "Vienna Capitals"],
        ["league" => "CHL", "value" => "BAN", "text" => "Banksa Bystrica"],
        ["league" => "CHL", "value" => "BEL", "text" => "Belfast Giants"],
        ["league" => "CHL", "value" => "CAR", "text" => "Cardiff Devils"],
        ["league" => "CHL", "value" => "FRI", "text" => "Frisk Asker"],
        ["league" => "CHL", "value" => "GKS", "text" => "GKS Tychy"],
        ["league" => "CHL", "value" => "GRN", "text" => "Grenoble Bruleurs de Loups"],
        ["league" => "CHL", "value" => "RUN", "text" => "Rungsted Seier Capital"],
        ["league" => "CHL", "value" => "MIN", "text" => "Yunost Minsk"],
        ["league" => "ELH", "value" => "PSG", "text" => "Aukro Berani Zlin"],
        ["league" => "ELH", "value" => "TYG", "text" => "Bili Tygri Liberec"],
        ["league" => "ELH", "value" => "MLA", "text" => "BK Mlada Boleslav"],
        ["league" => "ELH", "value" => "PAR", "text" => "Dynamo Pardubice"],
        ["league" => "ELH", "value" => "KRL", "text" => "HC Energie Karlovy Vary"],
        ["league" => "ELH", "value" => "OLO", "text" => "HC Olomouc"],
        ["league" => "ELH", "value" => "SKO", "text" => "HC Skoda Plzen"],
        ["league" => "ELH", "value" => "VIT", "text" => "HC Vitkovice Steel"],
        ["league" => "ELH", "value" => "BRN", "text" => "Kometa Brno"],
        ["league" => "ELH", "value" => "MTF", "text" => "Mountfield HK"],
        ["league" => "ELH", "value" => "TRI", "text" => "Ocelari Trinec"],
        ["league" => "ELH", "value" => "KLD", "text" => "Rytiri Kladno"],
        ["league" => "ELH", "value" => "SPA", "text" => "Sparta Praha"],
        ["league" => "ELH", "value" => "VER", "text" => "Verva Litvinov"],
        ["league" => "Allsvenska", "value" => "AIK", "text" => "AIK"],
        ["league" => "Allsvenska", "value" => "AIS", "text" => "Almtuna IS"],
        ["league" => "Allsvenska", "value" => "BIK", "text" => "BIK Karlskoga"],
        ["league" => "Allsvenska", "value" => "VIT", "text" => "HC Vita Hasten"],
        ["league" => "Allsvenska", "value" => "BJO", "text" => "IF Bjorkloven"],
        ["league" => "Allsvenska", "value" => "KHK", "text" => "Karlskrona HK"],
        ["league" => "Allsvenska", "value" => "KRI", "text" => "Kristianstad IK"],
        ["league" => "Allsvenska", "value" => "MOD", "text" => "MODO Hockey"],
        ["league" => "Allsvenska", "value" => "MOR", "text" => "Mora IK"],
        ["league" => "Allsvenska", "value" => "SOD", "text" => "Sodertalje SK"],
        ["league" => "Allsvenska", "value" => "TIM", "text" => "Timra IK"],
        ["league" => "Allsvenska", "value" => "TIN", "text" => "Tingsryds AIF"],
        ["league" => "Allsvenska", "value" => "VIK", "text" => "Vasterviks IK"],
        ["league" => "Allsvenska", "value" => "VAS", "text" => "VIK Vasteras HK"],
        ["league" => "National", "value" => "AUS", "text" => "Austria"],
        ["league" => "National", "value" => "CAN", "text" => "Canada"],
        ["league" => "National", "value" => "CZE", "text" => "Czech Republic"],
        ["league" => "National", "value" => "DEN", "text" => "Denmark"],
        ["league" => "National", "value" => "FIN", "text" => "Finland"],
        ["league" => "National", "value" => "FRA", "text" => "France"],
        ["league" => "National", "value" => "GER", "text" => "Germany"],
        ["league" => "National", "value" => "GRE", "text" => "Great Britain"],
        ["league" => "National", "value" => "ITL", "text" => "Italy"],
        ["league" => "National", "value" => "LAT", "text" => "Latvia"],
        ["league" => "National", "value" => "NOR", "text" => "Norway"],
        ["league" => "National", "value" => "RUS", "text" => "Russia"],
        ["league" => "National", "value" => "SLO", "text" => "Slovakia"],
        ["league" => "National", "value" => "SWE", "text" => "Sweden"],
        ["league" => "National", "value" => "SZL", "text" => "Switzerland"],
        ["league" => "National", "value" => "UKR", "text" => "Ukraine"],
        ["league" => "National", "value" => "USA", "text" => "United States of America"],
    ],
    "nationality" => [
        "Australia", "Austria", "Belarus", "Belgium", "Canada", "Croatia", "Czech Republic", "Denmark", "England", "Estonia", "Finland", "France", "Germany", "Hungary", "Italy", "Latvia", "Liberia", "Lithuania", "Netherlands", "Norway", "Poland", "Romania", "Russia", "Slovakia", "Slovenia", "Sweden", "Switzerland", "USA", "Ukraine",
    ],
    "hand" => [
        ["value" => "ANY", "title" => "Both"],
        ["value" => "right", "title" => "Right"],
        ["value" => "left", "title" => "Left"],
    ],
    "position" => [
        ["value" => "ANY", "title" => "All"],
        ["value" => "FWD", "title" => "Forwards"],
        ["value" => "DEF", "title" => "Defense"],
        ["value" => "LW", "title" => "LW"],
        ["value" => "C", "title" => "C"],
        ["value" => "RW", "title" => "RW"],
        ["value" => "LD", "title" => "LD"],
        ["value" => "RD", "title" => "RD"],
    ],
    "height" => [
        ["value" => "241", "title" => "7' 11"],
        ["value" => "239", "title" => "7' 10"],
        ["value" => "236", "title" => "7' 9"],
        ["value" => "234", "title" => "7' 8"],
        ["value" => "231", "title" => "7' 7"],
        ["value" => "229", "title" => "7' 6"],
        ["value" => "226", "title" => "7' 5"],
        ["value" => "224", "title" => "7' 4"],
        ["value" => "221", "title" => "7' 3"],
        ["value" => "218", "title" => "7' 2"],
        ["value" => "216", "title" => "7' 1"],
        ["value" => "213", "title" => "7' 0"],
        ["value" => "211", "title" => "6' 11"],
        ["value" => "208", "title" => "6' 10"],
        ["value" => "206", "title" => "6' 9"],
        ["value" => "203", "title" => "6' 8"],
        ["value" => "201", "title" => "6' 7"],
        ["value" => "198", "title" => "6' 6"],
        ["value" => "196", "title" => "6' 5"],
        ["value" => "193", "title" => "6' 4"],
        ["value" => "190", "title" => "6' 3"],
        ["value" => "188", "title" => "6' 2"],
        ["value" => "185", "title" => "6' 1"],
        ["value" => "183", "title" => "6' 0"],
        ["value" => "180", "title" => "5' 11"],
        ["value" => "178", "title" => "5' 10"],
        ["value" => "175", "title" => "5' 9"],
        ["value" => "173", "title" => "5' 8"],
        ["value" => "170", "title" => "5' 7"],
        ["value" => "168", "title" => "5' 6"],
        ["value" => "165", "title" => "5' 5"],
        ["value" => "163", "title" => "5' 4"],
        ["value" => "160", "title" => "5' 3"],
        ["value" => "157", "title" => "5' 2"],
        ["value" => "155", "title" => "5' 1"],
        ["value" => "152", "title" => "5' 0"],
        ["value" => "150", "title" => "4' 11"],
        ["value" => "147", "title" => "4' 10"],
        ["value" => "145", "title" => "4' 9"],
        ["value" => "142", "title" => "4' 8"],
        ["value" => "140", "title" => "4' 7"],
        ["value" => "137", "title" => "4' 6"],
        ["value" => "135", "title" => "4' 5"],
        ["value" => "132", "title" => "4' 4"],
        ["value" => "130", "title" => "4' 3"],
        ["value" => "127", "title" => "4' 2"],
        ["value" => "124", "title" => "4' 1"],
        ["value" => "122", "title" => "4' 0"],
        ["value" => "119", "title" => "3' 11"],
        ["value" => "117", "title" => "3' 10"],
        ["value" => "114", "title" => "3' 9"],
        ["value" => "112", "title" => "3' 8"],
        ["value" => "109", "title" => "3' 7"],
        ["value" => "107", "title" => "3' 6"],
        ["value" => "104", "title" => "3' 5"],
        ["value" => "102", "title" => "3' 4"],
        ["value" => "99", "title" => "3' 3"],
        ["value" => "97", "title" => "3' 2"],
        ["value" => "94", "title" => "3' 1"],
    ]


];


$botman = resolve('botman');

function filterMenu($bot, $message)
{
    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $full_name = $bot->userStorage()->get("full_name") ?? null;
    $card = $bot->userStorage()->get("card") ?? null;
    $ptype = $bot->userStorage()->get("ptype") ?? null;
    $synergies = $bot->userStorage()->get("synergies") ?? null;
    $league = $bot->userStorage()->get("league") ?? null;
    $team = $bot->userStorage()->get("team") ?? null;
    $nationality = $bot->userStorage()->get("nationality") ?? null;
    $position = $bot->userStorage()->get("position") ?? null;
    $hand = $bot->userStorage()->get("hand") ?? null;


    $overall_min = $bot->userStorage()->get("overall_min") ?? null;
    $overall_max = $bot->userStorage()->get("overall_max") ?? null;

    $overall = ($overall_min || $overall_max) ?? null;

    $height_min = $bot->userStorage()->get("height_min") ?? null;
    $height_max = $bot->userStorage()->get("height_max") ?? null;

    $height = ($height_min || $height_max) ?? null;

    $weight_min = $bot->userStorage()->get("weight_min") ?? null;
    $weight_max = $bot->userStorage()->get("weight_max") ?? null;

    $weight = ($weight_min || $weight_max) ?? null;

    $keyboard = [
        ["Применить фильтр"],
        ["Player Name" . ($full_name == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Player Type" . ($ptype == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
        ["Card Type" . ($card == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Synergy" . ($synergies == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
        ["League" . ($league == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Team" . ($team == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
        ["Nationality" . ($nationality == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Overall" . ($overall == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
        ["Height Min" . ($height_min == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Height Max" . ($height_max == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
        ["Weight" . ($weight == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
        ["Position" . ($position == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85"), "Hand" . ($hand == null ? "\xE2\x9D\x8E" : "\xE2\x9C\x85")],
        ["Сбросить фильтр"],
        ["Главное меню"],
    ];


    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => $message,
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'keyboard' => $keyboard,
                'one_time_keyboard' => false,
                'resize_keyboard' => true
            ])

        ]);
}

$botman->hears("/start|Главное меню", BotManController::class . '@cardSearchConversation');

$botman->hears("Все карточки", function ($bot) {
    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $query = "draw=5&start=0&length=10";

    try {
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
                'content' => $query
            ),
        ));

        ini_set('max_execution_time', 1000000);
        $content = file_get_contents(
            $file = 'https://nhlhutbuilder.com/php/player_stats.php',
            $use_include_path = false,
            $context);
        ini_set('max_execution_time', 60);


    } catch (ErrorException $e) {
        $content = [];
    }

    $cards = json_decode($content)->data;

    foreach ($cards as $key => $c) {
        $start = strpos($c->card_art, '<img src="') + 10;
        $end = strpos($c->card_art, '" width');
        $path = substr($c->card_art, $start, $end - $start);
        $imgUrl = 'https://nhlhutbuilder.com/' . $path;

        $pattern = "/([0-9]+)/";

        preg_match_all($pattern, $path, $matches);

        $cardId = $matches[1][0];

        $keybord = [
            [
                ['text' => "\xF0\x9F\x83\x8FИнформация по карточке", 'callback_data' => "/card_info $cardId"]
            ]
        ];

        if ($key == 9) {
            array_push($keybord, [['text' => "\xE2\x8F\xA9Еще карточки", 'callback_data' => '/all_cards 1']]);
        }

        $bot->sendRequest("sendPhoto",
            [
                "chat_id" => "$id",
                "photo" => $imgUrl,
                'reply_markup' => json_encode([
                    'inline_keyboard' =>
                        $keybord
                ])
            ]);
    }
});

$botman->hears("/card_info ([0-9]+)", function ($bot, $cardId) {

    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    try {
        ini_set('max_execution_time', 1000000);
        $content = file_get_contents("https://nhlhutbuilder.com/player-stats.php?sb=1&id=$cardId");
        ini_set('max_execution_time', 60);
    } catch (ErrorException $e) {
        $content = "";
    }


    $caption = "";
    $playerTitle = HTMLDomParser::str_get_html($content)->find('#player_header')[0]->plaintext;

    $caption .= "*$playerTitle*\n";
    $image = "https://nhlhutbuilder.com/" . HTMLDomParser::str_get_html($content)->find('#card_art')[0]->src;


    $bioTableTitles = HTMLDomParser::str_get_html($content)->find('#player_bio_table tr td.bio_title');
    $bioTableResults = HTMLDomParser::str_get_html($content)->find('#player_bio_table tr td.bio_result');


    $stats = [];


    foreach ($bioTableTitles as $row)
        array_push($stats, ["title" => $row->plaintext]);

    foreach ($bioTableResults as $key => $row)
        $caption .= "*" . $stats[$key]["title"] . "*:_" . $row->plaintext . "_\n";

    $caption .= "\n*Puck Skills:*\n";

    $deking = HTMLDomParser::str_get_html($content)->find('#deking')[0]->plaintext;
    $hand_eye = HTMLDomParser::str_get_html($content)->find('#hand-eye')[0]->plaintext;
    $passing = HTMLDomParser::str_get_html($content)->find('#passing')[0]->plaintext;
    $puck_control = HTMLDomParser::str_get_html($content)->find('#puck_control')[0]->plaintext;

    $caption .= "*Deking:*_ $deking _\n";
    $caption .= "*Hand-eye:*_ $hand_eye _\n";
    $caption .= "*Passing:*_ $passing _\n";
    $caption .= "*Puck Control:*_ $puck_control _\n";

    $caption .= "\n*Shooting:*\n";
    $slap_shot_accuracy = HTMLDomParser::str_get_html($content)->find('#slap_shot_accuracy')[0]->plaintext;
    $slap_shot_power = HTMLDomParser::str_get_html($content)->find('#slap_shot_power')[0]->plaintext;
    $wrist_shot_accuracy = HTMLDomParser::str_get_html($content)->find('#wrist_shot_accuracy')[0]->plaintext;
    $wrist_shot_power = HTMLDomParser::str_get_html($content)->find('#wrist_shot_power')[0]->plaintext;

    $caption .= "*Slap Shot Accuracy:*_ $slap_shot_accuracy _\n";
    $caption .= "*Slap Shot Power:*_ $slap_shot_power _\n";
    $caption .= "*Wrist Shot Accuracy:*_ $wrist_shot_accuracy _\n";
    $caption .= "*Wrist Shot Power:*_ $wrist_shot_power _\n";

    $caption .= "\n*Skating:*\n";
    $acceleration = HTMLDomParser::str_get_html($content)->find('#acceleration')[0]->plaintext;
    $agility = HTMLDomParser::str_get_html($content)->find('#agility')[0]->plaintext;
    $balance = HTMLDomParser::str_get_html($content)->find('#balance')[0]->plaintext;
    $endurance = HTMLDomParser::str_get_html($content)->find('#endurance')[0]->plaintext;

    $caption .= "*Acceleration:*_ $acceleration _\n";
    $caption .= "*Agility:*_ $agility _\n";
    $caption .= "*Balance:*_ $balance _\n";
    $caption .= "*Endurance:*_ $deking _\n";
    $caption .= "*Speed:*_ $endurance _\n";

    $caption .= "\n*Senses:*\n";
    $discipline = HTMLDomParser::str_get_html($content)->find('#discipline')[0]->plaintext;
    $off_awareness = HTMLDomParser::str_get_html($content)->find('#off_awareness')[0]->plaintext;
    $poise = HTMLDomParser::str_get_html($content)->find('#poise')[0]->plaintext;

    $caption .= "*Discipline:*_ $discipline _\n";
    $caption .= "*Offensive Awareness:*_ $off_awareness _\n";
    $caption .= "*Poise:*_ $poise _\n";

    $caption .= "\n*Physical:*\n";
    $aggression = HTMLDomParser::str_get_html($content)->find('#aggression')[0]->plaintext;
    $body_checking = HTMLDomParser::str_get_html($content)->find('#body_checking')[0]->plaintext;
    $durability = HTMLDomParser::str_get_html($content)->find('#durability')[0]->plaintext;
    $strength = HTMLDomParser::str_get_html($content)->find('#strength')[0]->plaintext;
    $fighting_skill = HTMLDomParser::str_get_html($content)->find('#fighting_skill')[0]->plaintext;

    $caption .= "*Aggression:*_ $aggression _\n";
    $caption .= "*Body Checking:*_ $body_checking _\n";
    $caption .= "*Durability:*_ $durability _\n";
    $caption .= "*Strength:*_ $strength _\n";
    $caption .= "*Fighting Skill:*_ $fighting_skill _\n";

    $caption .= "\n*Defenses:*\n";
    $def_awareness = HTMLDomParser::str_get_html($content)->find('#def_awareness')[0]->plaintext;
    $faceoffs = HTMLDomParser::str_get_html($content)->find('#faceoffs')[0]->plaintext;
    $shot_blocking = HTMLDomParser::str_get_html($content)->find('#shot_blocking')[0]->plaintext;
    $stick_checking = HTMLDomParser::str_get_html($content)->find('#stick_checking')[0]->plaintext;

    $caption .= "*Defensive Awareness:*_ $def_awareness _\n";
    $caption .= "*Face Offs:*_ $faceoffs _\n";
    $caption .= "*Shot Blocking:*_ $shot_blocking _\n";
    $caption .= "*Stick Checking:*_ $stick_checking _\n";


    $bot->sendRequest("sendPhoto",
        [
            "chat_id" => "$id",
            "caption" => $caption,
            "photo" => $image,
            "parse_mode" => "Markdown",

        ]);

    $otherImages = HTMLDomParser::str_get_html($content)->find('.other_card_art');

    foreach ($otherImages as $url) {
        $pattern = "/([0-9]+)/";

        preg_match_all($pattern, $url, $matches);

        $cardId = $matches[1][0];

        $keybord = [
            [
                ['text' => "\xE2\x8F\xA9Информация по карточке", 'callback_data' => "/card_info $cardId"]
            ]
        ];

        $bot->sendRequest("sendPhoto",
            [
                "chat_id" => "$id",
                "photo" => "https://nhlhutbuilder.com/" . $url->src,
                "parse_mode" => "Markdown",
                'reply_markup' => json_encode([
                    'inline_keyboard' =>
                        $keybord
                ])

            ]);
    }


});

$botman->hears("Player Name.*", BotManController::class . '@playerNameConversation');
$botman->hears("Overall.*", BotManController::class . '@overallConversation');
$botman->hears("Weight.*", BotManController::class . '@weightConversation');

$botman->hears("Position.*", function ($bot) {
    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $inline_keyboard = [];
    $tmp_menu = [];

    foreach (MENU["position"] as $key => $ptype) {

        array_push($tmp_menu, ["text" => $ptype["title"], "callback_data" => "/filter position " . $ptype["value"]]);

        if ($key % 4 == 0 || count(MENU["position"]) == $key + 1) {
            array_push($inline_keyboard, $tmp_menu);
            $tmp_menu = [];
        }
    }

    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => "Выбор фильтра",
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard,

            ])

        ]);
});

$botman->hears("Hand.*", function ($bot) {
    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $inline_keyboard = [];
    $tmp_menu = [];

    foreach (MENU["hand"] as $key => $ptype)
        array_push($tmp_menu, ["text" => $ptype["title"], "callback_data" => "/filter hand " . $ptype["value"]]);

    array_push($inline_keyboard, $tmp_menu);

    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => "Выбор фильтра",
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard,

            ])

        ]);
});

$botman->hears("Height Min.*", function ($bot) {
    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $inline_keyboard = [];
    $tmp_menu = [];

    foreach (MENU["height"] as $key => $ptype) {

        array_push($tmp_menu, ["text" => $ptype["title"], "callback_data" => "/filter height_min " . $ptype["value"]]);

        if ($key % 6 == 0 || count(MENU["height"]) == $key + 1) {
            array_push($inline_keyboard, $tmp_menu);
            $tmp_menu = [];
        }
    }

    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => "Выбор фильтра",
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard,

            ])

        ]);
});

$botman->hears("Height Max.*", function ($bot) {
    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $inline_keyboard = [];
    $tmp_menu = [];

    foreach (MENU["height"] as $key => $ptype) {

        array_push($tmp_menu, ["text" => $ptype["title"], "callback_data" => "/filter height_max " . $ptype["value"]]);

        if ($key % 6 == 0 || count(MENU["height"]) == $key + 1) {
            array_push($inline_keyboard, $tmp_menu);
            $tmp_menu = [];
        }
    }

    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => "Выбор фильтра",
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard,

            ])

        ]);
});

$botman->hears("Player Type.*", function ($bot) {
    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $inline_keyboard = [];
    $tmp_menu = [];

    foreach (MENU["player_type"] as $key => $ptype) {

        array_push($tmp_menu, ["text" => $ptype["title"], "callback_data" => "/filter ptype " . $ptype["value"]]);

        if ($key % 3 == 0 || count(MENU["player_type"]) == $key + 1) {
            array_push($inline_keyboard, $tmp_menu);
            $tmp_menu = [];
        }
    }

    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => "Выбор фильтра",
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard,

            ])

        ]);
});

$botman->hears("Card Type.*", function ($bot) {

    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $inline_keyboard = [];
    $tmp_menu = [];

    foreach (MENU["card_type"] as $key => $ptype) {

        array_push($tmp_menu, ["text" => $ptype["title"], "callback_data" => "/filter card " . $ptype["value"]]);

        if ($key % 3 == 0 || count(MENU["card_type"]) == $key + 1) {
            array_push($inline_keyboard, $tmp_menu);
            $tmp_menu = [];
        }
    }

    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => "Выбор фильтра",
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard,
            ])

        ]);
});

$botman->hears("Synergy.*", function ($bot) {

    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $inline_keyboard = [];
    $tmp_menu = [];

    foreach (MENU["synergy"] as $key => $ptype) {

        array_push($tmp_menu, ["text" => $ptype["title"], "callback_data" => "/filter synergies " . $ptype["value"]]);

        if ($key % 3 == 0 || count(MENU["synergy"]) == $key + 1) {
            array_push($inline_keyboard, $tmp_menu);
            $tmp_menu = [];
        }
    }

    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => "Выбор фильтра",
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard,
            ])

        ]);
});

$botman->hears("League.*", function ($bot) {

    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $inline_keyboard = [];
    $tmp_menu = [];

    foreach (MENU["league"] as $key => $ptype) {

        array_push($tmp_menu, ["text" => $ptype["title"], "callback_data" => "/filter league " . $ptype["value"]]);

        if ($key % 5 == 0 || count(MENU["league"]) == $key + 1) {
            array_push($inline_keyboard, $tmp_menu);
            $tmp_menu = [];
        }
    }

    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => "Выбор фильтра",
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard,
            ])

        ]);
});

$botman->hears("Team.*", function ($bot) {

    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $league = $bot->userStorage()->get("league") ?? null;

    if ($league == null) {
        $bot->reply("Лига не выбрана!");
        return;
    }
    $inline_keyboard = [];
    $tmp_menu = [];


    array_push($tmp_menu, ["text" => "ANY", "callback_data" => "/filter team ANY"]);
    foreach (MENU["all_teams"] as $key => $ptype) {

        if ($ptype["league"] == $league || $league == null) {
            array_push($tmp_menu, ["text" => $ptype["text"], "callback_data" => "/filter team " . $ptype["value"]]);

            if ($key % 3 == 0 || count(MENU["all_teams"]) == $key + 1) {
                array_push($inline_keyboard, $tmp_menu);
                $tmp_menu = [];
            }
        }
    }

    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => "Выбор фильтра",
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard,
            ])

        ]);
});

$botman->hears("Nationality.*", function ($bot) {

    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();


    $inline_keyboard = [];
    $tmp_menu = [];


    foreach (MENU["nationality"] as $key => $ptype) {


        array_push($tmp_menu, ["text" => $ptype, "callback_data" => "/filter nationality " . $ptype]);

        if ($key % 4 == 0 || count(MENU["nationality"]) == $key + 1) {
            array_push($inline_keyboard, $tmp_menu);
            $tmp_menu = [];
        }

    }

    $bot->sendRequest("sendMessage",
        [
            "chat_id" => "$id",
            "text" => "Выбор фильтра",
            "parse_mode" => "Markdown",
            'reply_markup' => json_encode([
                'inline_keyboard' => $inline_keyboard,
            ])

        ]);
});

$botman->hears("Поиск карточек|Фильтр карточек", function ($bot) {
    filterMenu($bot, "Выбо фильтра");
});
$botman->hears("/all_cards ([0-9]+)", function ($bot, $page) {
    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();


    $query = "draw=5&start=" . ($page * 10) . "&length=10";

    try {
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
                'content' => $query
            ),
        ));

        ini_set('max_execution_time', 1000000);
        $content = file_get_contents(
            $file = 'https://nhlhutbuilder.com/php/player_stats.php',
            $use_include_path = false,
            $context);
        ini_set('max_execution_time', 60);


    } catch (ErrorException $e) {
        $content = [];
    }

    $cards = json_decode($content)->data;

    foreach ($cards as $key => $c) {
        $start = strpos($c->card_art, '<img src="') + 10;
        $end = strpos($c->card_art, '" width');
        $path = substr($c->card_art, $start, $end - $start);
        $imgUrl = 'https://nhlhutbuilder.com/' . $path;

        $pattern = "/([0-9]+)/";

        preg_match_all($pattern, $path, $matches);

        $cardId = $matches[1][0];

        $keybord = [
            [
                ['text' => "\xF0\x9F\x83\x8FИнформация по карточке", 'callback_data' => "/card_info $cardId"]
            ]
        ];

        if ($key == 9) {
            if ($page > 0)
                array_push($keybord, [
                    ['text' => "\xE2\x8F\xA9Дальше", 'callback_data' => '/all_cards ' . ($page + 1)],
                    ['text' => "\xE2\x8F\xAAНазад", 'callback_data' => '/all_cards ' . ($page - 1)],
                ]);

            if ($page == 0)
                array_push($keybord, [
                    ['text' => "\xE2\x8F\xA9Дальше", 'callback_data' => '/all_cards ' . ($page + 1)],
                ]);
        }

        $bot->sendRequest("sendPhoto",
            [
                "chat_id" => "$id",
                "photo" => $imgUrl,
                'reply_markup' => json_encode([
                    'inline_keyboard' =>
                        $keybord
                ])
            ]);
    }
});

$botman->hears("Применить фильтр", function ($bot) {
    $telegramUser = $bot->getUser();
    $id = $telegramUser->getId();

    $index = -1;

    $full_name = $bot->userStorage()->get("full_name") ?? null;
    $card = $bot->userStorage()->get("card") ?? null;
    $ptype = $bot->userStorage()->get("ptype") ?? null;
    $synergies = $bot->userStorage()->get("synergies") ?? null;
    $league = $bot->userStorage()->get("league") ?? null;
    $team = $bot->userStorage()->get("team") ?? null;
    $nationality = $bot->userStorage()->get("nationality") ?? null;
    $position = $bot->userStorage()->get("position") ?? null;
    $hand = $bot->userStorage()->get("hand") ?? null;


    $overall_min = $bot->userStorage()->get("overall_min") ?? null;
    $overall_max = $bot->userStorage()->get("overall_max") ?? null;

    $overall = ($overall_min && $overall_max) ?? null;

    $height_min = $bot->userStorage()->get("height_min") ?? null;
    $height_max = $bot->userStorage()->get("height_max") ?? null;

    $height = ($height_min && $height_max) ?? null;

    $weight_min = $bot->userStorage()->get("weight_min") ?? null;
    $weight_max = $bot->userStorage()->get("weight_max") ?? null;

    $weight = ($weight_min && $weight_max) ?? null;

    $query = "draw=5&start=0&length=10";

    if ($overall)
        $query .= "&columns[" . (++$index) . "][data]=overall&columns[$index][search][value]=$overall_min<$overall_max&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";

    if ($full_name)
        $query .= "&columns[" . (++$index) . "][data]=full_name&columns[$index][search][value]=$full_name&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";

    if ($league)
        $query .= "&columns[" . (++$index) . "][data]=league&columns[$index][search][value]=$league";

    if ($position)
        $query .= "&columns[" . (++$index) . "][data]=position&columns[$index][search][value]=$position&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";

    if ($hand)
        $query .= "&columns[" . (++$index) . "][data]=hand&columns[$index][search][value]=$hand&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";

    if ($height)
        $query .= "&columns[" . (++$index) . "][data]=height&columns[$index][search][value]=$height_min<$height_max&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";
    if ($synergies)
        $query .= "&columns[" . (++$index) . "][data]=synergies&columns[$index][search][value]=$synergies&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";
    if ($team)
        $query .= "&columns[" . (++$index) . "][data]=team&columns[$index][search][value]=$team&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";

    if ($ptype)
        $query .= "&columns[" . (++$index) . "][data]=ptype&columns[$index][search][value]=$ptype&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";

    if ($card)
        $query .= "&columns[" . (++$index) . "][data]=card&columns[$index][search][value]=$card&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";

    if ($weight)
        $query .= "&columns[" . (++$index) . "][data]=weight&columns[$index][search][value]=$weight_min<$weight_max&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";

    if ($nationality)
        $query .= "&columns[" . (++$index) . "][data]=nationality&columns[$index][search][value]=$nationality&columns[${index}][searchable]=true&columns[$index][orderable]=true&columns[$index][search][regex]=true";


    Log::info($query);

    try {
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
                'content' => $query
            ),
        ));

        ini_set('max_execution_time', 1000000);
        $content = file_get_contents(
            $file = 'https://nhlhutbuilder.com/php/player_stats.php',
            $use_include_path = false,
            $context);
        ini_set('max_execution_time', 60);


    } catch (ErrorException $e) {
        $content = [];
    }

    $cards = json_decode($content)->data;

    foreach ($cards as $key => $c) {
        $start = strpos($c->card_art, '<img src="') + 10;
        $end = strpos($c->card_art, '" width');
        $path = substr($c->card_art, $start, $end - $start);
        $imgUrl = 'https://nhlhutbuilder.com/' . $path;

        $pattern = "/([0-9]+)/";

        preg_match_all($pattern, $path, $matches);

        $cardId = $matches[1][0];

        $keybord = [
            [
                ['text' => "\xF0\x9F\x83\x8FИнформация по карточке", 'callback_data' => "/card_info $cardId"]
            ]
        ];

        $bot->sendRequest("sendPhoto",
            [
                "chat_id" => "$id",
                "photo" => $imgUrl,
                'reply_markup' => json_encode([
                    'inline_keyboard' =>
                        $keybord
                ])
            ]);
    }
});

$botman->hears("/filter ([a-z_]+) ([a-zA-Z0-9 ]+)", function ($bot, $name, $value) {

    $bot->userStorage()->save([
        "$name" => $value == "ANY" ? null : $value
    ]);

    filterMenu($bot, "Фильтр $name изменен");
});

$botman->hears("Как пользоваться", function ($bot) {
    $bot->reply("About");

    $userinformation = $bot->userStorage()->get("name");


    $bot->reply("About $userinformation");
});


$botman->hears("Сбросить фильтр", function ($bot) {
    $bot->userStorage()->delete();

    filterMenu($bot, "Фильтры сброшены");

});

