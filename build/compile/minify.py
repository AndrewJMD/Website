import glob, os

for filename in glob.iglob('www/**/*.js', recursive=True):
    if not filename.endswith(".min.js"):
        print("uglifyjs "+filename+" -o "+filename)
        os.system("uglifyjs "+filename+" -o "+filename)
