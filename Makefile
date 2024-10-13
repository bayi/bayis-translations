
all:
	@rm Forditasok.zip || true
	zip -r Forditasok.zip Forditasok

chipped:
	@echo "Creating translations for chipped..."
	php gen.php orig/chipped.json Forditasok/assets/chipped/lang/hu_hu.json
