Thème bootstrap venant de https://bootswatch.com/

Première installation (nécessite PHP, symfony et composer d'installés) :  
> git clone https://github.com/Armantos/Projet_eCommerce  
> cd Projet_eCommerce  
> composer install  

Mise à jour avec la derniere version :  
> git pull origin master

Importation base de données :  
phpmyadmin > Importation > ecommerce.sql

Ou alors depuis symfony :  
>symfony console make:migration 
>symfony console doctrine:migrations:migrate  
