
# covid19AT
![HealthCheck](https://healthchecks.io/badge/398fe207-255b-43fd-9f63-bb488c/aAz0uawd.svg)

Shows COVID-19 data for the country austria based by states.
covid19AT was converting text to json data, but is now using public data from data.gv.at.
![Anwendung](https://i.imgur.com/wWsDVg0.jpg)

So the old data was purged and is accessible from an old commit. [Link](https://github.com/fellwell5/covid19AT/commit/f17a8652792083d20440bc5b3a35da1a85193750#diff-cee0b842780b2d9984790ccb70b5d80c)

~~Gets the COVID-19 stats from the austrian goverment and formats it machine readable.
covid19AT is using a public listing from the austrian goverment to load the data.~~

# API endpoint
You can also use the public API endpoint:
```
https://covid.masch.xyz/api/
```

# Statistics
Check out the public statistics page:
[https://covid.masch.xyz/](https://covid.masch.xyz/)

# Installation
The installation is fairly simple. Just copy the covid19AT.php in your desired location.

Now you are setup and ready to go!

# Example output
```json
{
  "timestamp": 1595782800,
  "date": 1595782800,
  "time": 1595782800,
  "total": {
    "tested_persons": 847898,
    "infected": 20486,
    "recovered": 18209,
    "dead": 688,
    "currently_sick": 1551,
    "population": 8904511,
    "tested_persons_percent": 9.522117497524569,
    "infected_percent": 0.23006316686003309,
    "recovered_percent": 0.2044918581155102,
    "dead_percent": 0.007726420911827725,
    "currently_sick_percent": 0.01741813784047209
  },
  "details": {
    "currently_sick": {
      "information": {
        "name": "Zurzeit Erkrankt",
        "name_en": "Currently Sick",
        "updated_timestamp": 1595782800,
        "updated_datetime": "2020-07-26T19:00:00"
      },
      "states": {
        "w": 546,
        "v": 25,
        "t": 54,
        "st": 109,
        "s": 74,
        "o": 460,
        "n": 247,
        "k": 11,
        "b": 25
      }
    },
    "recovered": {
      "information": {
        "name": "Genesen",
        "name_en": "Recovered",
        "updated_timestamp": 1595782800,
        "updated_datetime": "2020-07-26T19:00:00"
      },
      "states": {
        "b": 362,
        "k": 430,
        "n": 2936,
        "o": 2978,
        "s": 1226,
        "st": 1786,
        "t": 3500,
        "v": 901,
        "w": 4090
      }
    },
    "dead": {
      "information": {
        "name": "Verstorben",
        "name_en": "Dead",
        "updated_timestamp": 1595782800,
        "updated_datetime": "2020-07-26T19:00:00"
      },
      "states": {
        "b": 11,
        "k": 13,
        "n": 107,
        "o": 58,
        "s": 37,
        "st": 142,
        "t": 101,
        "v": 18,
        "w": 201
      }
    },
    "district_infected": {
      "information": {
        "name": "Infiziert (nach Bezirk)",
        "name_en": "Infected (by district)",
        "updated_timestamp": 1595782800,
        "updated_datetime": "2020-07-26T19:00:00"
      },
      "states": {
        "101": 19,
        "103": 28,
        "104": 26,
        "105": 10,
        "106": 81,
        "107": 66,
        "108": 26,
        "109": 145,
        "201": 102,
        "202": 24,
        "203": 5,
        "204": 51,
        "205": 54,
        "206": 46,
        "207": 51,
        "208": 55,
        "209": 50,
        "210": 15,
        "301": 45,
        "302": 109,
        "303": 27,
        "304": 89,
        "305": 314,
        "306": 221,
        "307": 136,
        "308": 131,
        "309": 16,
        "310": 48,
        "311": 97,
        "312": 196,
        "313": 173,
        "314": 54,
        "315": 190,
        "316": 146,
        "317": 227,
        "318": 238,
        "319": 289,
        "320": 105,
        "321": 194,
        "322": 76,
        "323": 109,
        "325": 74,
        "401": 667,
        "402": 75,
        "403": 139,
        "404": 162,
        "405": 82,
        "406": 140,
        "407": 115,
        "408": 90,
        "409": 65,
        "410": 491,
        "411": 350,
        "412": 76,
        "413": 171,
        "414": 66,
        "415": 200,
        "416": 335,
        "417": 170,
        "418": 128,
        "501": 192,
        "502": 80,
        "503": 242,
        "504": 456,
        "505": 26,
        "506": 371,
        "601": 571,
        "603": 54,
        "606": 261,
        "610": 193,
        "611": 38,
        "612": 109,
        "614": 9,
        "616": 106,
        "617": 205,
        "620": 52,
        "621": 64,
        "622": 321,
        "623": 68,
        "701": 443,
        "702": 297,
        "703": 409,
        "704": 376,
        "705": 540,
        "706": 1009,
        "707": 156,
        "708": 63,
        "709": 358,
        "801": 270,
        "802": 283,
        "803": 161,
        "804": 226,
        "900": 4797
      }
    },
    "infected": {
      "information": {
        "name": "Infizierte",
        "name_en": "Infected",
        "updated_timestamp": 1595782800,
        "updated_datetime": "2020-07-26T19:00:00"
      },
      "states": {
        "b": 398,
        "k": 454,
        "n": 3290,
        "o": 3496,
        "s": 1337,
        "st": 2037,
        "t": 3655,
        "v": 944,
        "w": 4837
      }
    }
  },
  "states": {
    "b": {
      "name": "Burgenland",
      "name_en": "Burgenland",
      "population": 294466,
      "infected": 398,
      "recovered": 362,
      "dead": 11,
      "currently_sick": 25,
      "infected_percent": 0.13515991659478513,
      "recovered_percent": 0.12293439650078446,
      "dead_percent": 0.0037355755842779816,
      "currently_sick_percent": 0.008489944509722685
    },
    "k": {
      "name": "Kärnten",
      "name_en": "Carinthia",
      "population": 561390,
      "infected": 454,
      "recovered": 430,
      "dead": 13,
      "currently_sick": 11,
      "infected_percent": 0.08087069595112133,
      "recovered_percent": 0.07659559308145852,
      "dead_percent": 0.002315680721067351,
      "currently_sick_percent": 0.0019594221485954503
    },
    "n": {
      "name": "Niederösterreich",
      "name_en": "Lower Austria",
      "population": 1684623,
      "infected": 3290,
      "recovered": 2936,
      "dead": 107,
      "currently_sick": 247,
      "infected_percent": 0.19529592080839453,
      "recovered_percent": 0.17428231717126028,
      "dead_percent": 0.006351569460941706,
      "currently_sick_percent": 0.014662034176192537
    },
    "o": {
      "name": "Oberösterreich",
      "name_en": "Upper Austria",
      "population": 1490392,
      "infected": 3496,
      "recovered": 2978,
      "dead": 58,
      "currently_sick": 460,
      "infected_percent": 0.23456916032828945,
      "recovered_percent": 0.19981320350619167,
      "dead_percent": 0.003891593621007091,
      "currently_sick_percent": 0.03086436320109072
    },
    "s": {
      "name": "Salzburg",
      "name_en": "Salzburg",
      "population": 558479,
      "infected": 1337,
      "recovered": 1226,
      "dead": 37,
      "currently_sick": 74,
      "infected_percent": 0.23940022811958908,
      "recovered_percent": 0.21952481651055814,
      "dead_percent": 0.006625137203010319,
      "currently_sick_percent": 0.013250274406020638
    },
    "st": {
      "name": "Steiermark",
      "name_en": "Styria",
      "population": 1246576,
      "infected": 2037,
      "recovered": 1786,
      "dead": 142,
      "currently_sick": 109,
      "infected_percent": 0.1634076061146693,
      "recovered_percent": 0.14327245190024515,
      "dead_percent": 0.011391202782662268,
      "currently_sick_percent": 0.008743951431761883
    },
    "t": {
      "name": "Tirol",
      "name_en": "Tyrol",
      "population": 757852,
      "infected": 3655,
      "recovered": 3500,
      "dead": 101,
      "currently_sick": 54,
      "infected_percent": 0.4822841399112228,
      "recovered_percent": 0.46183159772620513,
      "dead_percent": 0.013327140391527633,
      "currently_sick_percent": 0.007125401793490022
    },
    "v": {
      "name": "Vorarlberg",
      "name_en": "Vorarlberg",
      "population": 397094,
      "infected": 944,
      "recovered": 901,
      "dead": 18,
      "currently_sick": 25,
      "infected_percent": 0.2377270872891557,
      "recovered_percent": 0.22689841699950136,
      "dead_percent": 0.0045329317491576305,
      "currently_sick_percent": 0.0062957385404967085
    },
    "w": {
      "name": "Wien",
      "name_en": "Vienna",
      "population": 1911728,
      "infected": 4837,
      "recovered": 4090,
      "dead": 201,
      "currently_sick": 546,
      "infected_percent": 0.25301716562188764,
      "recovered_percent": 0.21394256923579089,
      "dead_percent": 0.010514048023568206,
      "currently_sick_percent": 0.02856054836252856
    }
  }
}
```
