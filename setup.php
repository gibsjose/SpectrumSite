<?php
    function setupSpectrumEnv() {

       # echo " setupSpectrumEnv Setup for SLC6";

        $afs_work="/afs/cern.ch/work/a/applgrid/public/usr-slc6/";
        $_ENV["SPX_SYSTEM"]= "x86_64-slc6-gcc46-opt";
        $_ENV["ROOTSYS"]= "/afs/cern.ch/sw/lcg/app/releases/ROOT/5.34.05/".$_ENV["SPX_SYSTEM"]."/root";
        $_ENV["APPLGRID"] = "$afs_work"."/applgrid/1.4.56";
        $_ENV["HOPPET"] = "$afs_work"."/hoppet/1.1.5";
        $_ENV["LHAPDF"] = "$afs_work"."/lhapdf/5.9.1";
        $_ENV["LHAPDF"] = "/afs/cern.ch/sw/lcg/external/MCGenerators/lhapdf/5.8.9/".$_ENV["SPX_SYSTEM"];
        $_ENV["SPX_PATH"]= "PATH=".$_ENV["ROOTSYS"]."/bin:".$_ENV["APPLGRID"]."/bin:".$_ENV["HOPPET"]."/bin:".$_ENV["LHAPDF"]."/bin".":".$_ENV["PATH"];
        $_ENV["SPX_LIBS"]= "/afs/cern.ch/sw/lcg/contrib/gcc/4.6/".$_ENV["SPX_SYSTEM"]."/lib64:/afs/cern.ch/sw/lcg/contrib/mpfr/4.3.2/".$_ENV["SPX_SYSTEM"]."/lib:/afs/cern.ch/sw/lcg/contrib/gmp/4.3.2/".$_ENV["SPX_SYSTEM"]."/lib:/usr/lib64/";
        $_ENV["SPX_LD_LIBRARY_PATH"]= "LD_LIBRARY_PATH=".$_ENV["ROOTSYS"]."/lib:".$_ENV["APPLGRID"]."/lib:".$_ENV["HOPPET"]."/lib:".$_ENV["LHAPDF"]."/lib:".$_ENV["SPX_LIBS"].":".$_ENV["LD_LIBRARY_PATH"];


        putenv($_ENV["SPX_PATH"]);
        putenv($_ENV["SPX_LD_LIBRARY_PATH"]);

#       echo " \n setup done";
       
    }
    
    function menu() {

    }

    function footer() {

    }
?>
