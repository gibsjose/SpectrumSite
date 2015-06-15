<?php
    function setupSpectrumEnv() {

       echo " setupSpectrumEnv Setup for SLC6 gcc48";

        # $_ENV["SPX_SYSTEM"]= "x86_64-slc6-gcc46-opt";
        $_ENV["SPX_SYSTEM"]= "x86_64-slc6-gcc48-opt";
        $afs_work="/afs/cern.ch/work/a/applgrid/public/".$_ENV["SPX_SYSTEM"];
        #$_ENV["ROOTSYS"]= "/afs/cern.ch/sw/lcg/app/releases/ROOT/6.02.05/".$_ENV["SPX_SYSTEM"]."/root";
        $_ENV["ROOTSYS"]= "/afs/cern.ch/sw/lcg/app/releases/ROOT/5.34.24/".$_ENV["SPX_SYSTEM"]."/root";
        $_ENV["APPLGRID"] = "$afs_work"."/applgrid/1.4.73/root-5.34.24";
        $_ENV["HOPPET"] = "$afs_work"."/hoppet/1.1.5";
        #$_ENV["LHAPDF"] = "$afs_work"."/lhapdf/5.9.1";
        $_ENV["LHAPDFPATH"] = "/afs/cern.ch/sw/lcg/external/MCGenerators_lcgcmt67b/lhapdf6/6.1.5/";
        #$_ENV["LHAPDFPATH"] = "/afs/cern.ch/sw/lcg/external/MCGenerators_lcgcmt67b/lhapdf/5.9.1";
        $_ENV["LHAPDFBIN"] = $_ENV["LHAPDFPATH"]."/".$_ENV["SPX_SYSTEM"];
        #$_ENV["LHAPATH"] = $_ENV["LHAPDFPATH"]."/share/lhapdf/PDFsets";
        #$_ENV["LHAPATH"] = "/afs/cern.ch/sw/lcg/external/MCGenerators/lhapdf/5.8.9/share/PDFsets";
        $_ENV["LHAPATH"] ="LHAPATH="."/afs/cern.ch/sw/lcg/external/lhapdfsets/current";         

        $_ENV["SPX_PATH"]= "PATH=".$_ENV["ROOTSYS"]."/bin:".$_ENV["APPLGRID"]."/bin:".$_ENV["HOPPET"]."/bin:".$_ENV["LHAPDFBIN"]."/bin".":".$_ENV["PATH"];
#        $_ENV["SPX_LIBS"]= "/afs/cern.ch/sw/lcg/contrib/gcc/4.6/".$_ENV["SPX_SYSTEM"]."/lib64:/afs/cern.ch/sw/lcg/contrib/mpfr/4.3.2/".$_ENV["SPX_SYSTEM"]."/lib:/afs/cern.ch/sw/lcg/contrib/gmp/4.3.2/".$_ENV["SPX_SYSTEM"]."/lib:/usr/lib64/";
#        $_ENV["SPX_LIBS"]= "/afs/cern.ch/sw/lcg/contrib/gcc/4.8.1/".$_ENV["SPX_SYSTEM"]."/lib64:/afs/cern.ch/sw/lcg/contrib/mpfr/3.1.2/".$_ENV["SPX_SYSTEM"]."/lib:/afs/cern.ch/sw/lcg/contrib/gmp/5.1.1/".$_ENV["SPX_SYSTEM"]."/lib:/usr/lib64/";
        $_ENV["SPX_LIBS"]= "/afs/cern.ch/sw/lcg/contrib/gcc/4.8.1/".$_ENV["SPX_SYSTEM"]."/lib64:/afs/cern.ch/sw/lcg/contrib/mpfr/3.1.2/".$_ENV["SPX_SYSTEM"]."/lib:/afs/cern.ch/sw/lcg/contrib/gmp/5.1.1/".$_ENV["SPX_SYSTEM"]."/lib";
        $_ENV["SPX_LD_LIBRARY_PATH"]= "LD_LIBRARY_PATH=".$_ENV["APPLGRID"]."/lib:".$_ENV["ROOTSYS"]."/lib:".$_ENV["HOPPET"]."/lib:".$_ENV["LHAPDFBIN"]."/lib:".$_ENV["SPX_LIBS"].":".$_ENV["LD_LIBRARY_PATH"];


        putenv($_ENV["SPX_PATH"]);
        putenv($_ENV["SPX_LD_LIBRARY_PATH"]);

        putenv($_ENV["LHAPATH"]);

        #echo '<br> My username is ' .$_ENV["$USER"] . '<br> ';
	#echo "<br> \n SPX_LD_LIBRARY_PATH = " . $_ENV["SPX_LD_LIBRARY_PATH"];
	#echo "<br> \n SPX_PATH = " . $_ENV["SPX_PATH"];
	#echo "<br> \n LHAPATH = " . $_ENV["LHAPATH"];
	#echo "<br> \n ";

        #echo " ls -lR /afs/cern.ch/project/oracle/linux/9206/lib/XXX";
        #$last_line = system('gcc --version', $retval);
        #$last_line = system('ls -l /afs/cern.ch/project/oracle/linux/9206/lib', $retval);
        #$last_line = system('lhapdf-config --version', $retval);
        #$last_line = system('ls -ltr /afs/cern.ch/sw/lcg/contrib/gcc/4.8/x86_64-slc6-gcc48-opt', $retval);
        #echo "<br> last line $last_line retval= $retval ";

        #echo "<br> \n setup done ";
       
    }
    
    function menu() {

    }

    function footer() {

    }
?>
