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
  "date": "14.03.2020",
  "time": "15:00",
  "timestamp": 1584194400,
  "total": {
    "population": 8904511,
    "tested_persons": 7467,
    "infected": 655,
    "recovered": 6,
    "dead": 1,
    "currently_sick": 648,
    "tested_persons_percent": 0.08385637347182794,
    "infected_percent": 0.007355822234370871,
    "recovered_percent": 0.00006738157771942784,
    "dead_percent": 0.000011230262953237971,
    "currently_sick_percent": 0.007277210393698205
  },
  "details": {
    "infected": {
      "information": {
        "name": "Bestätigte Fälle",
        "name_en": "Infected",
        "updated_date": "14.03.2020",
        "updated_time": "15:00",
        "updated_timestamp": 1584194400
      },
      "states": {
        "b": 10,
        "k": 0,
        "n": 82,
        "o": 116,
        "s": 30,
        "st": 71,
        "t": 206,
        "v": 34,
        "w": 101
      }
    },
    "recovered": {
      "information": {
        "name": "Genesene Personen",
        "name_en": "Recovered",
        "updated_date": "14.03.2020",
        "updated_time": "15:00",
        "updated_timestamp": 1584194400
      },
      "states": {
        "b": 0,
        "k": 0,
        "n": 1,
        "o": 0,
        "s": 0,
        "st": 0,
        "t": 2,
        "v": 0,
        "w": 3
      }
    },
    "dead": {
      "information": {
        "name": "Todesfälle",
        "name_en": "Dead",
        "updated_date": "14.03.2020",
        "updated_time": "15:00",
        "updated_timestamp": 1584194400
      },
      "states": {
        "b": 0,
        "k": 0,
        "n": 0,
        "o": 0,
        "s": 0,
        "st": 0,
        "t": 0,
        "v": 0,
        "w": 1
      }
    }
  },
  "states": {
    "b": {
      "name": "Burgenland",
      "name_en": "Burgenland",
      "population": 294466,
      "infected": 10,
      "recovered": 0,
      "dead": 0,
      "currently_sick": 10,
      "infected_percent": 0.003395977803889074,
      "recovered_percent": 0,
      "dead_percent": 0,
      "currently_sick_percent": 0.003395977803889074
    },
    "k": {
      "name": "Kärnten",
      "name_en": "Carinthia",
      "population": 561390,
      "infected": 0,
      "recovered": 0,
      "dead": 0,
      "currently_sick": 0,
      "infected_percent": 0,
      "recovered_percent": 0,
      "dead_percent": 0,
      "currently_sick_percent": 0
    },
    "n": {
      "name": "Niederösterreich",
      "name_en": "Lower Austria",
      "population": 1684623,
      "infected": 82,
      "recovered": 1,
      "dead": 0,
      "currently_sick": 81,
      "infected_percent": 0.004867557904646915,
      "recovered_percent": 0.00005936046225179165,
      "dead_percent": 0,
      "currently_sick_percent": 0.004808197442395123
    },
    "o": {
      "name": "Oberösterreich",
      "name_en": "Upper Austria",
      "population": 1490392,
      "infected": 116,
      "recovered": 0,
      "dead": 0,
      "currently_sick": 116,
      "infected_percent": 0.007783187242014182,
      "recovered_percent": 0,
      "dead_percent": 0,
      "currently_sick_percent": 0.007783187242014182
    },
    "s": {
      "name": "Salzburg",
      "name_en": "Salzburg",
      "population": 558479,
      "infected": 30,
      "recovered": 0,
      "dead": 0,
      "currently_sick": 30,
      "infected_percent": 0.005371732867305664,
      "recovered_percent": 0,
      "dead_percent": 0,
      "currently_sick_percent": 0.005371732867305664
    },
    "st": {
      "name": "Steiermark",
      "name_en": "Styria",
      "population": 1246576,
      "infected": 71,
      "recovered": 0,
      "dead": 0,
      "currently_sick": 71,
      "infected_percent": 0.005695601391331134,
      "recovered_percent": 0,
      "dead_percent": 0,
      "currently_sick_percent": 0.005695601391331134
    },
    "t": {
      "name": "Tirol",
      "name_en": "Tyrol",
      "population": 757852,
      "infected": 206,
      "recovered": 2,
      "dead": 0,
      "currently_sick": 204,
      "infected_percent": 0.027182088323313786,
      "recovered_percent": 0.00026390377012926007,
      "dead_percent": 0,
      "currently_sick_percent": 0.026918184553184527
    },
    "v": {
      "name": "Vorarlberg",
      "name_en": "Vorarlberg",
      "population": 397094,
      "infected": 34,
      "recovered": 0,
      "dead": 0,
      "currently_sick": 34,
      "infected_percent": 0.008562204415075523,
      "recovered_percent": 0,
      "dead_percent": 0,
      "currently_sick_percent": 0.008562204415075523
    },
    "w": {
      "name": "Wien",
      "name_en": "Vienna",
      "population": 1911728,
      "infected": 101,
      "recovered": 3,
      "dead": 1,
      "currently_sick": 97,
      "infected_percent": 0.005283178360101437,
      "recovered_percent": 0.00015692608990400307,
      "dead_percent": 0.00005230869663466769,
      "currently_sick_percent": 0.005073943573562767
    }
  }
}
```
