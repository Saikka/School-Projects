import os, os.path
import sys
import time
import shutil
import datetime
import configparser

def ds():
	config = configparser.ConfigParser()
	config.read('darksouls.ini')
	source = config.get('DEFAULT','game_file')
	starttime=time.time() 
	while True: 
		print("copied")
		dest = shutil.copyfile(config.get('DEFAULT','game_file'), config.get('DEFAULT','saving_directory') + str(datetime.datetime.now()).replace(':', '.') + '.' + source.split(".",1)[1] ) 
		list = os.listdir(config.get('DEFAULT','saving_directory'))
		while True:
			if len(list) <= config.getint('DEFAULT','number_of_copies'):
				break
			else:
				os.chdir(config.get('DEFAULT','saving_directory'))
				files = sorted(os.listdir(os.getcwd()), key=os.path.getmtime)
				os.remove(files[0])
				list = os.listdir(config.get('DEFAULT','saving_directory'))
		time.sleep(config.getint('DEFAULT','time_interval_in_minutes') * 60)


ds()
