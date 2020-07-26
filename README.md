
# covid19AT
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
  "date": "26.07.2020",
  "time": "18:00",
  "timestamp": 1595779200,
  "total": {
    "tested_persons": 847898,
    "infected": 20482,
    "recovered": 18209,
    "dead": 688,
    "currently_sick": 1551,
    "population": 8904511,
    "tested_persons_percent": 9.522117497524569,
    "infected_percent": 0.2300182458082201,
    "recovered_percent": 0.2044918581155102,
    "dead_percent": 0.007726420911827725,
    "currently_sick_percent": 0.01741813784047209
  },
  "details": {
    "currently_sick": {
      "information": {
        "name": "Zurzeit Erkrankt",
        "name_en": "Currently Sick",
        "updated_timestamp": 1595779200
      },
      "states": {
        "w": {
          "number": 546,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "v": {
          "number": 25,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "t": {
          "number": 54,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "st": {
          "number": 109,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "s": {
          "number": 74,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "o": {
          "number": 460,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "n": {
          "number": 247,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "k": {
          "number": 11,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "b": {
          "number": 25,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        }
      }
    },
    "recovered": {
      "information": {
        "name": "Genesen",
        "name_en": "Recovered",
        "updated_timestamp": 1595779200
      },
      "states": {
        "b": {
          "number": 362,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "k": {
          "number": 430,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "n": {
          "number": 2936,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "o": {
          "number": 2978,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "s": {
          "number": 1226,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "st": {
          "number": 1786,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "t": {
          "number": 3500,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "v": {
          "number": 901,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "w": {
          "number": 4090,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        }
      }
    },
    "dead": {
      "information": {
        "name": "Verstorben",
        "name_en": "Dead",
        "updated_timestamp": 1595779200
      },
      "states": {
        "b": {
          "number": 11,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "k": {
          "number": 13,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "n": {
          "number": 107,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "o": {
          "number": 58,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "s": {
          "number": 37,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "st": {
          "number": 142,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "t": {
          "number": 101,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "v": {
          "number": 18,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        },
        "w": {
          "number": 201,
          "timestamp": 1595779200,
          "datetime": "2020-07-26T18:00:00"
        }
      }
    },
    "infected": {
      "information": {
        "name": "Infizierte",
        "name_en": "Infected",
        "updated_timestamp": 1595779200
      },
      "states": {
        "b": {
          "number": 398
        },
        "k": {
          "number": 454
        },
        "n": {
          "number": 3290
        },
        "o": {
          "number": 3496
        },
        "s": {
          "number": 1337
        },
        "st": {
          "number": 2037
        },
        "t": {
          "number": 3655
        },
        "v": {
          "number": 944
        },
        "w": {
          "number": 4837
        }
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
