#!/usr/bin/python

import sys

# Input dictionary from KVP file
d = {}

# Defaults dictionary
defaults = {}

# Checks whether the key exists in the input dictionary
def Write(_key, _file):
    print("Looking for key: " + key)
    if _key in d:
        _file.write(_key + ' = ' + d[_key] + '\n')
        print("key found")
    elif _key in defaults:
        _file.write(_key + ' = ' + defaults[_key] + '\n')
        print("default key found")
    else:
        print("key not found")

inputPath = sys.argv[1]
outputPath = sys.argv[2]

# Open the key-value-pair file and create a dictionary out of it
#with open(inputPath, 'r') as f:
f = open(inputPath, 'r')
for line in f:
    (key, val) = line.split(' = ')
    d[key] = val
f.close()

# Create default dictionary

# [GEN]
defaults['debug'] = 'true'

# [GRAPH]
defaults['plot_band'] = 'false'
defaults['plot_error_ticks'] = 'false'
defaults['plot_marker'] = 'true'
defaults['plot_staggered'] = 'true'
defaults['match_binning'] = 'true'
defaults['grid_corr'] = 'false'
defaults['label_sqrt_s'] = 'true'
defaults['x_legend'] = '0.9'
defaults['y_legend'] = '0.9'
defaults['y_overlay_min'] = ''
defaults['y_overlay_max'] = ''
defaults['y_ratio_min'] = ''
defaults['y_ratio_max'] = ''

# [PLOT_0]
defaults['plot_type'] = 'data, grid, pdf'
defaults['desc'] = ''
defaults['data_directory'] = '.'
defaults['grid_directory'] = '.'
defaults['pdf_directory'] = '.'
defaults['data_steering_files'] = 'none'
defaults['grid_steering_files'] = 'none'
defaults['pdf_steering_files'] = 'none'
#defaults['data_marker_style'] = '20'
#defaults['data_marker_color'] = '1'
#defaults['pdf_fill_style'] = ''
#defaults['pdf_fill_color'] = ''
#defaults['pdf_marker_style'] = ''
defaults['x_scale'] = '1.0'
defaults['y_scale'] = '1.0'
defaults['x_log'] = 'true'
defaults['y_log'] = 'true'
defaults['display_style'] = 'overlay'
defaults['overlay_style'] = 'data, convolute'
defaults['ratio_title'] = 'Ratio'

# Write the Steering File
#with open(outputPath, 'w') as f:
f = open(outputPath, 'w')

# [GEN]
f.write('\n\n[GEN]\n')
Write('debug', f)

# [GRAPH]
f.write('\n\n[GRAPH]\n')
Write('plot_band', f)
Write('plot_error_ticks', f)
Write('plot_marker', f)
Write('plot_staggered', f)
Write('match_binning', f)
Write('grid_corr', f)
Write('label_sqrt_s', f)
Write('x_legend', f)
Write('y_legend', f)
Write('y_overlay_min', f)
Write('y_overlay_max', f)
Write('y_ratio_min', f)
Write('y_ratio_max', f)

# [PLOT_0]
f.write('\n\n[PLOT_0]\n')
Write('plot_type', f)
Write('desc', f)
Write('data_directory', f)
Write('grid_directory', f)
Write('pdf_directory', f)
Write('data_steering_files', f)
Write('grid_steering_files', f)
Write('pdf_steering_files', f)
Write('data_marker_style', f)
Write('data_marker_color', f)
Write('pdf_fill_style', f)
Write('pdf_fill_color', f)
Write('pdf_marker_style', f)
Write('x_scale', f)
Write('y_scale', f)
Write('x_log', f)
Write('y_log', f)
Write('display_style', f)
Write('overlay_style', f)
Write('ratio_title', f)

#Look for up to 10 ratios
for i in range(0, 10):
    rs = 'ratio_style_' + str(i)
    r = 'ratio_' + str(i)
    Write(rs)
    Write(r)

f.close()
