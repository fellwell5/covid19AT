# covid19AT
Gets the COVID-19 stats from the austrian goverment and formats it machine readable.

covid19AT is using a public listing from the austrian goverment to load the data.

The source of the data looks like this:

[![Public listing](https://imgur.com/M0pJeln.png)](https://www.sozialministerium.at/Informationen-zum-Coronavirus/Neuartiges-Coronavirus-(2019-nCov).html)

# Installation
The installation is fairly simple. Just copy the covid19AT.php in your desired location.

Now you are setup and ready to go!

# Example output
```json
{
  "data_source": "https://www.sozialministerium.at/Informationen-zum-Coronavirus/Neuartiges-Coronavirus-(2019-nCov).html",
  "date": "13.03.2020",
  "time": "15:00",
  "timestamp": 1584108000,
  "total": {
    "tested_persons": "6582",
    "infected": "504",
    "recovered": "6",
    "dead": "1",
    "currently_sick": 497
  },
  "details": {
    "infected": {
      "information": {
        "name": "Bestätigte Fälle",
        "name_en": "Infected",
        "updated_date": "13.03.2020",
        "updated_time": "15:00",
        "updated_timestamp": 1584108000
      },
      "states": {
        "b": "7",
        "n": "63",
        "o": "68",
        "s": "23",
        "st": "52",
        "t": "167",
        "v": "22",
        "w": "82"
      }
    },
    "recovered": {
      "information": {
        "name": "Genesene Personen",
        "name_en": "Recovered",
        "updated_date": "13.03.2020",
        "updated_time": "08:00",
        "updated_timestamp": 1584082800
      },
      "states": {
        "n": "1",
        "t": "2",
        "w": "3"
      }
    },
    "dead": {
      "information": {
        "name": "Todesfälle",
        "name_en": "Dead",
        "updated_date": "13.03.2020",
        "updated_time": "08:00",
        "updated_timestamp": 1584082800
      },
      "states": {
        "w": "1"
      }
    }
  },
  "states": {
    "b": {
      "name": "Burgenland",
      "name_en": "Burgenland",
      "infected": "7",
      "recovered": 0,
      "dead": 0,
      "currently_sick": 7
    },
    "k": {
      "name": "Kärnten",
      "name_en": "Carinthia",
      "infected": 0,
      "recovered": 0,
      "dead": 0,
      "currently_sick": 0
    },
    "n": {
      "name": "Niederösterreich",
      "name_en": "Lower Austria",
      "infected": "63",
      "recovered": "1",
      "dead": 0,
      "currently_sick": 62
    },
    "o": {
      "name": "Oberösterreich",
      "name_en": "Upper Austria",
      "infected": "68",
      "recovered": 0,
      "dead": 0,
      "currently_sick": 68
    },
    "s": {
      "name": "Salzburg",
      "name_en": "Salzburg",
      "infected": "23",
      "recovered": 0,
      "dead": 0,
      "currently_sick": 23
    },
    "st": {
      "name": "Steiermark",
      "name_en": "Styria",
      "infected": "52",
      "recovered": 0,
      "dead": 0,
      "currently_sick": 52
    },
    "t": {
      "name": "Tirol",
      "name_en": "Tyrol",
      "infected": "167",
      "recovered": "2",
      "dead": 0,
      "currently_sick": 165
    },
    "v": {
      "name": "Vorarlberg",
      "name_en": "Vorarlberg",
      "infected": "22",
      "recovered": 0,
      "dead": 0,
      "currently_sick": 22
    },
    "w": {
      "name": "Wien",
      "name_en": "Vienna",
      "infected": "82",
      "recovered": "3",
      "dead": "1",
      "currently_sick": 78
    }
  }
}
```
