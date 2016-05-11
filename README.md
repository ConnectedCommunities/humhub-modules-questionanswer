Question and Answer
========
[in development]

A Stack Exchange inspired Question and Answer system for Humhub. 

Add code to config/local/_settings.php in Components array to urlManager rules

'/' => '/questionanswer/question/picked',

If you disable module you need to delete the line below: '/' => '/questionanswer/question/picked',

instruction about how to restart the module if migrations were updated
0) disable module
1) Delete all tables and records created in migration, example  http://i.imgur.com/hzEdifg.png -> http://i.imgur.com/rxFYho1.png(chose delete) and  http://i.imgur.com/mlm8b8R.png. And delete the record itself in migration table http://i.imgur.com/u6chz2B.png -> http://i.imgur.com/3PMuLil.png
2) Make module pull
3) Run module
4) Check the all records and tables created in migration.
