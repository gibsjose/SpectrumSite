#!/usr/bin/python

#This script outputs the HTML required to load the Data Steering File list with the proper data files, as listed
#in the /config/observables.config file

#The input required is the observable name, exactly as spelled in the configuration file

import sys, os, traceback, optparse
import time
import re

class ObservableInstance:
    def __init__(self, displayName):
        self.displayName = displayName
        self.data = {}

    def PrintDataHTML(self):
        for key in self.data:
            data = self.data[key]
            print('<h2 value=\"' + data.fullPath + '\">' + data.displayName + '</h2>')

class DataInstance:
    def __init__(self, displayName, fullPath):
        self.displayName = displayName
        self.fullPath = fullPath
        self.grids = {}

    def PrintGridsHTML(self):
        for key in self.grids:
            grid = self.grids[key]
            print('<h2 value=\"' + grid.fullPath + '\">' + grid.displayName + '</h2>')

class GridInstance:
    def __init__(self, displayName, fullPath):
        self.displayName = displayName
        self.fullPath = fullPath

class Configuration:
    def __init__(self, _filename):
        self.filename = _filename
        self.observables = {}

    # Get the observable with the given name
    def GetObservable(self, _key):
        if _key in self.observables:
            return self.observables[_key]
        else:
            return None

    # Get the data with the given name from any observable
    def GetData(self, _key):
        for key in self.observables:
            observable = self.observables[key]
            if _key in observable.data:
                return observable.data[_key]

        return None

    # Print the configuration tree
    def Print(self):
        for key in self.observables:
            observable = self.observables[key]
            print(observable.displayName)
            for key in observable.data:
                data = observable.data[key]
                print('\t' + data.displayName)
                for key in data.grids:
                    grid = data.grids[key]
                    print('\t\t' + grid.displayName)

    # Create the configuration tree from reading in the file
    def Create(self):
        #Open observables configuration file
        cf = open(self.filename, 'r')

        for line in cf:
            #Strip trailing and leading whitespace
            line = line.strip()

            #Skip comments
            if line.startswith('#'):
                continue

            #Skip empty lines
            elif not line:
                continue

            #Valid Lines
            else:
                #New Observable
                if line.startswith('[O]'):
                    # Get the observable name
                    clean = line.replace('[O]', '').strip()
                    observableName = clean

                    # Create a new observable instance
                    observableInstance = ObservableInstance(observableName)

                    # Add the observable to the configuration
                    self.observables[observableName] = observableInstance

                #New Data
                elif line.startswith('[D]'):
                    # Get the data name and path
                    clean = line.replace('[D]', '').strip()
                    (dataName, dataPath) = clean.split(',')

                    # Create a new data instance
                    dataInstance = DataInstance(dataName, dataPath)

                    # Add the data to the observable
                    self.observables[observableName].data[dataName] = dataInstance

                #New Grid
                elif line.startswith('[G]'):
                    # Get the grid name and path
                    clean = line.replace('[G]', '').strip()
                    (gridName, gridPath) = clean.split(',')

                    # Create a new grid instance
                    gridInstance = GridInstance(gridName, gridPath)

                    # Add the grid to the data
                    self.observables[observableName].data[dataName].grids[gridName] = gridInstance

def main ():

    global options, args

    #Create the configuration
    filename = './config/observables.config'
    configuration = Configuration(filename)

    #Create the configuration
    configuration.Create()

    #Print the configuration
    #configuration.Print()

    #Output all the grids associated with the observable->data
    if options.data:
        data = configuration.GetData(options.data)
        if data:
            data.PrintGridsHTML()

    #Output all the data associated with the observable
    elif options.observable:
        observable = configuration.GetObservable(options.observable)
        if observable:
            observable.PrintDataHTML()

if __name__ == '__main__':
    try:
        start_time = time.time()
        parser = optparse.OptionParser(formatter=optparse.TitledHelpFormatter(), usage=globals()['__doc__'], version='$Id$')
        parser.add_option ('-v', '--verbose', action='store_true', default=False, help='verbose output')
        parser.add_option ('-o', '--observable', dest="observable", help="print all the data associated with the observable OBS", metavar="OBS")
        parser.add_option ('-d', '--data', dest="data", help="print all the grids associated with the data DATA", metavar="DATA")
        (options, args) = parser.parse_args()
        # if len(args) < 1:
        #     parser.error ('missing argument')
        if options.verbose: print time.asctime()
        main()
        if options.verbose: print time.asctime()
        if options.verbose: print 'TOTAL TIME IN MINUTES:',
        if options.verbose: print (time.time() - start_time) / 60.0
        sys.exit(0)
    except KeyboardInterrupt, e: # Ctrl-C
        raise e
    except SystemExit, e: # sys.exit()
        raise e
    except Exception, e:
        print 'ERROR, UNEXPECTED EXCEPTION'
        print str(e)
        traceback.print_exc()
        os._exit(1)
