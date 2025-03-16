
all:
	@rm Forditasok.zip || true
	zip -r Forditasok.zip Forditasok

dist:
	@rm Forditasok-dist.zip || true
	@cd Forditasok && zip -q -r ../Forditasok-dist.zip .
