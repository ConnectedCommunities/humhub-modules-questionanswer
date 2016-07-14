Question and Answer
========
[in development]

A Stack Exchange inspired Question and Answer system for Humhub. 

Add code to config/common.php and add code only to Rules

  '/' => '/questionanswer/question/picked',

If you disable module you need to delete the line below: 

  '/' => '/questionanswer/question/picked',
