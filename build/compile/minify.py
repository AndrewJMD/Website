import glob, os

for filename in glob.iglob('www/**/*.js', recursive=True):
    if not filename.endswith(".min.js"):
        os.system("uglifyjs \""+filename+"\" > \""+filename+"\"")
