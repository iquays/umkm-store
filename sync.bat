REM batch program to synchronize jumkm on local and jumkm on W2008 Server
@Echo Off

robocopy.exe assets "z:\syauqi.eepis.ac.id\jumkm\assets" /MIR /R:1 /W:2 /TEE
robocopy.exe rbac "z:\syauqi.eepis.ac.id\jumkm\rbac" /MIR /R:1 /W:2 /TEE
robocopy.exe commands "z:\syauqi.eepis.ac.id\jumkm\commands" /MIR /R:1 /W:2 /TEE
robocopy.exe config "z:\syauqi.eepis.ac.id\jumkm\config" /MIR /R:1 /W:2 /TEE
robocopy.exe controllers "z:\syauqi.eepis.ac.id\jumkm\controllers" /MIR /R:1 /W:2 /TEE
robocopy.exe models "z:\syauqi.eepis.ac.id\jumkm\models" /MIR /R:1 /W:2 /TEE
robocopy.exe views "z:\syauqi.eepis.ac.id\jumkm\views" /MIR /R:1 /W:2 /TEE
robocopy.exe vendor "z:\syauqi.eepis.ac.id\jumkm\vendor" /MIR /R:1 /W:2 /TEE

robocopy.exe web "z:\syauqi.eepis.ac.id\jumkm\web" /R:1 /W:2 /TEE
robocopy.exe web\css "z:\syauqi.eepis.ac.id\jumkm\web\css" /MIR /R:1 /W:2 /TEE
robocopy.exe web\js "z:\syauqi.eepis.ac.id\jumkm\web\js" /MIR /R:1 /W:2 /TEE
robocopy.exe web\map "z:\syauqi.eepis.ac.id\jumkm\web\map" /MIR /R:1 /W:2 /TEE
robocopy.exe web\uploads "z:\syauqi.eepis.ac.id\jumkm\web\uploads" /MIR /R:1 /W:2 /TEE
robocopy.exe web\images "z:\syauqi.eepis.ac.id\jumkm\web\images" /MIR /R:1 /W:2 /TEE
