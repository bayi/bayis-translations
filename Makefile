
all:
	@rm Forditasok.zip || true
	zip -r Forditasok.zip Forditasok

dist:
	@rm Forditasok-dist.zip || true
	@cd Forditasok && zip -q -r ../Forditasok-dist.zip .

chipped:
	@echo "Creating translations for chipped..."
	php gen.php orig/chipped.json Forditasok/assets/chipped/lang/hu_hu.json

createdeco:
	@echo "Creating translations for createdeco..."
	php gen.php orig/createdeco.json Forditasok/assets/createdeco/lang/hu_hu.json
