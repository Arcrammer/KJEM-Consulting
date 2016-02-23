var gulp = require('gulp');
var exec = require('child_process').exec;

// Tasks
gulp.task('default', () => {
  duplicateProductionDatabase();
});

// Functions
function duplicateProductionDatabase() {
  // Duplicate the production database at ialexander.io to
  // the local computer in the 'KJEM-Development' database
  var dump_filename = "Production-dump.sql";

  // Throw an error if MySQL isn't running
  exec('mysql --password=$DOLOMITE_DATABASE_PASSWORD', (err) => {
    if (err) throw err;
  });

  // Get a dump of the production database
  console.log('Fetching the production database...');
  exec(`mysqldump -u alexander -h ialexander.io --password=$ULLMANNITE_DATABASE_PASSWORD KJEM-Production > ${dump_filename}`, (err, stdout, stderr) => {
    console.log('Got it! Importing it to \'KJEM-Development\'...');

    // Import the dump to MySQL on the development server
    exec(`mysql -u alexander --password=$DOLOMITE_DATABASE_PASSWORD KJEM-Development < ${dump_filename}`);
    exec(`rm ${dump_filename}`);

    console.log('Production database was successfully imported.');
  });
};
