var gulp = require('gulp');
var exec = require('child_process').exec;

gulp.task('default', () => {
  exec([
    'mysqldump -u alexander -h ialexander.io --password=$ULLMANNITE_DATABASE_PASSWORD KJEM-Production > Production-dump.sql',
    'mysql -u alexander --password=$DOLOMITE_DATABASE_PASSWORD KJEM-Development < Production-dump.sql',
    'rm Production-dump.sql'
  ].join(' && '), (err, stdout, stderr) => {
    if (err) throw err;
    console.log('The production database was duplicated.');
  })
});
