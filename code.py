import sys
sys.path.append('/home/anddyc1/py_libs/')

import web, ofdb, pages
import simplejson as json

# set urls for the application #
urls = ( '/', 'index',
         '/about', 'about',
         '/contact', 'contact',
         '/api-info', 'api_info',
         '/api/landings', 'landings',
         '/api/landings/countries', 'countries',
         '/api/landings/countries/(.+)', 'single_country',
         '/api/landings/species', 'species',
         '/api/landings/species/(.+)', 'single_species',
         '/api/landings/areas', 'areas',
         '/api/landings/countries/(.+)/species/(.+)', 'country_species',
         '/download', 'download' )

# start the application #
app = web.application(urls, globals())

# templating
render = web.template.render('templates/')

# common functions #
def result_to_json(query):
    result = ofdb.db.query(query)
    return json.dumps( [ row for row in result ] )

# the url classes #
class download:
    def GET(self):
        return render.layout("title here", "something here")

class single_species:
    def GET(self, species):
        q = "SELECT year, Sum(catch) as catch FROM capture WHERE a3_code = '" + species
        q += "' GROUP BY year ORDER BY year"
        web.header('Content-Type', 'application/json')
        return result_to_json(q)

class species:
    def GET(self):
        q = "SELECT scientific_name, english_name, a3_code, taxocode, isscaap FROM asfis"
        web.header('Content-Type', 'application/json')
        return result_to_json(q)

class areas:
    def GET(self):
        return "hello areas"

class countries:
    def GET(self):
        q = "SELECT country, iso3c FROM countries ORDER BY country"
        web.header('Content-Type', 'application/json')
        return result_to_json(q)

class single_country:
    def GET(self, country):
        q = "SELECT year, Sum(catch) as catch from capture WHERE "
        q += "iso3c = '" + country + "' GROUP BY year ORDER BY year"
        web.header('Content-Type', 'application/json')
        return result_to_json(q)

class country_species:
    def GET(self, country, species):
        q = "SELECT year, Sum(catch) as catch FROM capture WHERE "
        q += "iso3c = '" + country + "' AND a3_code = '" + species + "'"
        web.header('Content-Type', 'application/json')
        return result_to_json(q)

class landings:
    def GET(self):
        q = "SELECT year, Sum(catch) as catch from capture GROUP BY year ORDER BY year"
        web.header('Content-Type', 'application/json')
        return result_to_json(q)

class index:
    def GET(self):
        web.header('Content-Type', 'text/html; charset=utf-8', unique=True)
        return pages.home

class about:
    def GET(self):
        web.header('Content-Type', 'text/html; charset=utf-8', unique=True)
        return pages.about

class contact:
    def GET(self):
        web.header('Content-Type', 'text/html; charset=utf-8', unique=True)
        return pages.contact

class api_info:
    def GET(self):
        web.header('Content-Type', 'text/html; charset=utf-8', unique=True)
        return pages.api_info

if __name__ == "__main__":
    app.run()
else: 
    web.wsgi.runwsgi = lambda func, addr=None: web.wsgi.runfcgi(func, 
addr)


