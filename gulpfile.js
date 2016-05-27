"use strict";

let gulp = require('gulp');
let exec = require('child_process').exec;
let compass = require('gulp-compass');
let browserSync = require('browser-sync').create();

gulp.task('default', ['compass'], () => {
  // Start watching the Less files
  exec('cd wp-content/themes/freak/assets/less && watch-less -r ../css/ -e .css');

  // Start Browser-Sync
  browserSync.init({
    proxy: 'kjemconsulting.dev',
    files: [
      './wp-content/themes/freak-child/assets/css/*',
      './wp-content/themes/freak-child/assets/fonts/*',
      './wp-content/themes/freak-child/assets/icons/*',
      './wp-content/themes/freak-child/assets/images/*',
      './wp-content/themes/freak-child/assets/scripts/*',
      './wp-content/themes/freak-child/framework/layout/*.php',
      './wp-content/themes/freak-child/framework/widgets/*.php',
      './wp-content/themes/freak-child/inc/*.php',
      './wp-content/themes/freak-child/*.php',
      './wp-content/themes/freak-child/*.css',
      './wp-content/themes/freak-child/js/*'
    ],
    open: true,
    browser: "Google Chrome"
  });
});

gulp.task('compass', () => {
  gulp.src('./wp-content/themes/freak-child/*.scss')
    .pipe(compass({
      config_file: './config.rb',
      css: './wp-content/themes/freak-child/',
      sass: './wp-content/themes/freak-child/'
    }))
    .pipe(gulp.dest('./wp-content/themes/freak-child/'));
});

gulp.task('db:pull', (done) => {
  // Duplicate the production database at ialexander.io to
  // the local computer in the 'KJEM-Development' database
  var dump_filename = "Production-dump.sql";

  // Throw an error if MySQL isn't running
  exec('mysql --password=$DOLOMITE_DATABASE_PASSWORD', (err) => {
    if (err) throw err;
  });

  // Get a dump of the production database
  console.log('Fetching the production database...');
  exec(`mysqldump -u kjemcon1_wp_v3n9 -h kjemconsulting.com --password=$KJEM_PRODUCTION_PASSWORD kjemcon1_wp_v3n9 > ${dump_filename}`, (err, stdout, stderr) => {
    console.log('Got it! Importing it to \'KJEM-Development\'...');

    // Import the dump to MySQL on the development server
    exec(`mysql -u alexander --password=$DOLOMITE_DATABASE_PASSWORD KJEM-Development < ${dump_filename}`, () => {
      // Change the .beta TLD's to .dev in 'wp_posts'
      exec('mysql -u alexander --password=$DOLOMITE_DATABASE_PASSWORD -e "UPDATE wp_posts SET guid=replace(guid, \'.beta\', \'.dev\')" KJEM-Development', () => {
        exec(`rm ${dump_filename}`, () => {
          console.log('Production database was successfully imported.');
          done();
          process.exit();
        });
      });
    });
  });
});

gulp.task('db:push', (done) => {
  // Duplicate the development database at Dolomite to
  // the server in the 'kjemcon1_wp_v3n9' database
  var dump_filename = "Development-dump.sql";

  // Throw an error if MySQL isn't running
  exec('mysql --password=$DOLOMITE_DATABASE_PASSWORD', (err) => {
    if (err) throw err;
  });

  // Get a dump of the development database
  exec(`mysqldump -u alexander -h localhost --password=$DOLOMITE_DATABASE_PASSWORD KJEM-Development > ${dump_filename}`, (err, stdout, stderr) => {

    // Upload the dump to the production server
    console.log('Uploading the development database to the server...');
    exec(`scp -r ${dump_filename} kjem:~/${dump_filename}`, (err) => {

    // Import the dump to MySQL on the production server
    exec(`mysql -u kjemcon1_wp_v3n9 --password=$KJEM_PRODUCTION_PASSWORD kjemcon1_wp_v3n9 < ${dump_filename}`, () => {
        done();
        process.exit();
      });
    });
  });
})

gulp.task('assets', (done) => {
  exec('scp -r kjem:~/public_html/wp-content/uploads ./wp-content', (err) => {
    if (err) throw err;
    done();
  });
})
