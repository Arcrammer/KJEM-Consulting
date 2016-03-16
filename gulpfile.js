var gulp = require('gulp');
var exec = require('child_process').exec;

gulp.task('default', () => {
  // Start watching the Less files
  exec('cd wp-content/themes/freak/assets/less && watch-less -r ../css/ -e .css');

  // Start Browser-Sync
  exec('browser-sync start --config=bs-config.js');
});

gulp.task('sync', () => {
  // Duplicate the production database at ialexander.io to
  // the local computer in the 'KJEM-Development' database
  var dump_filename = "Production-dump.sql";

  // Throw an error if MySQL isn't running
  exec('mysql --password=$DOLOMITE_DATABASE_PASSWORD', (err) => {
    if (err) throw err;
  });

  // Get a dump of the production database
  console.log('Fetching the production database...');
  exec(`mysqldump -u kjemcon1 -h kjemconsulting.com --password=$KJEM_PRODUCTION_PASSWORD kjemcon1_wp_v3n9 > ${dump_filename}`, (err, stdout, stderr) => {
    console.log('Got it! Importing it to \'KJEM-Development\'...');

    // Import the dump to MySQL on the development server
    exec(`mysql -u alexander --password=$DOLOMITE_DATABASE_PASSWORD KJEM-Development < ${dump_filename}`, () => {
      // Change the .beta TLD's to .dev in 'wp_posts'
      exec('mysql -u alexander --password=$DOLOMITE_DATABASE_PASSWORD -e "UPDATE wp_posts SET guid=replace(guid, \'.beta\', \'.dev\')" KJEM-Development');
    });
    exec(`rm ${dump_filename}`);

    console.log('Production database was successfully imported.');
  });
});
