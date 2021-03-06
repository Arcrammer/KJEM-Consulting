"use strict";

let gulp = require('gulp');
let fs = require('fs');
let gutil = require('gulp-util');
let exec = require('child_process').exec;
let spawn = require('child_process').spawn;
let compass = require('gulp-compass');
let browserSync = require('browser-sync').create();

gulp.task('default', ['compass', 'browserSync'], () => {
  // Start watching the Less files
  exec('cd wp-content/themes/freak/assets/less && watch-less -r ../css/ -e .css');
});

gulp.task('compass', () => {
  gulp.src('./wp-content/themes/freak-child/*.scss')
    .pipe(compass({
      config_file: './config.rb',
      css: './wp-content/themes/freak-child/',
      sass: './wp-content/themes/freak-child/',
      sourcemap: true,
      debug: true,
      task: 'watch'
    }))
    .pipe(gulp.dest('./wp-content/themes/freak-child/'));
});

gulp.task('browserSync', () => {
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
      // Get rid of the dump file
      exec(`rm ${dump_filename}`, () => {
        gutil.log(gutil.colors.green('Production database was successfully imported.'));
        done();
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

  let mysqldump = spawn('mysqldump', [
    '-v',
    '-h kjemconsulting.com',
    '-u alexander',
    '--password=' + process.env.KJEM_PRODUCTION_PASSWORD,
    'kjemcon1_wp_v3n9 < KJEM-Development.sql'
  ], {
    stdio: 'inherit'
  });

  mysqldump.on('close', () => {
    console.log('All done');
    done();
    process.exit();
  });

  // Get a dump of the development database
  // exec(`mysqldump -u alexander -h localhost --password=$DOLOMITE_DATABASE_PASSWORD KJEM-Development > ${dump_filename}`, (err, stdout, stderr) => {
  //   // Import the dump to MySQL on the production server
  //   console.log("Uploading the development database");
    // exec(`mysql -u kjemcon1_wp_v3n9 --password=$KJEM_PRODUCTION_PASSWORD -h kjemconsulting.com kjemcon1_wp_v3n9 < ${dump_filename}`, (err) => {
  //     if (err) throw err;
  //     gutil.log(gutil.colors.green("All done"));
  //     done();
  //     process.exit();
  //   });
  // });
});

gulp.task('assets', (done) => {
  var scp = spawn('scp', [
    '-r',
    'kjem:~/public_html/wp-content/uploads',
    './wp-content'
  ], {
    stdio: 'inherit'
  });
  scp.on('close', () => {
    done();
    gutil.log(gutil.colors.green('All done. Now you have the same assets as the server'));
  });
});
