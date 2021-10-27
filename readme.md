# 🏀 NBA 2K19 Stats Viewer

You should have a PHP 7.1+ installed in your machine to run the application. Clone the repository then install the dependencies using composer.

```bash
git clone git@github.com:plmrlnsnts/nba-stats.git
cd nba-stats && composer install
```

This repository does not include the `database` folder. If you need the mysqldump, please use the code repository specified in the assessment document.

Changelogs:
- Leverage composer's autoloading features
- Rename "Controller" to "ReportController" for verbosity
- Add `app/Models` directory for POPOs
- Add `app/Repositories` directory to encapsulate data retrieval
- Add `app/Reports` directory to provide granular control over the data of each report
- Add `app/Formatters` directory for all the supported report formats
- Add `ReportManager` class that is reponsible for generating report and spitting out the expected format
- Add `resources/views/report.html` for the html template
- Add "sorting" feature, ex. `export.php?type=playerstats&sort=3pt&direction=desc`
