<?php

$file_handle = fopen('\\\\192.168.1.2\RxUniverse\OMICSTX\2.V2015', 'a+');
//$file_handle = fopen('C:\Users\oscargz\Desktop\2.V1014', 'a+');
fwrite($file_handle,
'PATIENT="LORENA GUADALUPE MENDEZ"
JOB="050920221"
DO=B
_JTYPE=1
_LSTYLE=ST28;ST28
_MATERIAL=P;P
SPH=+0.75;+0.25
CYL=0.00;0.00
AX=105;95
ADD=+2.75;+2.75
IPD=33.0;33.0
PRVM=0.00;0.00
HBOX=54.00
VBOX=40.00
DBL=18.00
_EDBOX=55
FTYP=2
ETYP=1
EOJ=END OF JOB');

fclose($file_handle);


