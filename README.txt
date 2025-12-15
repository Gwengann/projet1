
Ce fichier README a été généré le 2024/04/16 par Gwengann.


Dernière mise-à-jour le : 2024/04/16.


Arborescence/plan de classement des fichiers :


Projet1/
	Accueil/
		img/
			large/
			small/
		js/
		php/
		sql/
		index.html
	Authentifiaction
		js/
		php/
		sql/
		index.html
	Python/
	README.txt



Résumé du projet:

Ce projet comweb a pour but de créer une page HTML dynamique grâce au PHP et au Javascript.
J'ai fait un espace à gauche où se trouvent des images et si l'on clique dessus, l'image apparaît en plus grand et une section commentaire s'ouvre.
Les commentaires sont différents sous chaque photo et restent si vous changez de photo entre temps. Ils peuvent être modifiés et supprimés.
A droite se trouve un espace réservé au chat qui devient fonctionnel une fois le script python lancé. 
Le div destiné aux erreurs est caché et apparaît si une erreur a lieu.
Dans ce projet j'ai ajouté des fonctionnalités comme l'authentification qui était optionnel ainsi qu'une redirection entre 2 pages.


Fichier "Authentification":

Le dossier "Authentifiaction" est la première page HTML à ouvrir. Il a pour but de vous identifier et de vous amener à la suite du projet se trouvant dans "Accueil".
Les 2 seuls id de connexion qui fonctionnent sont les combinaisons "cir2/cir2" et "m2/m2", si un autre identifiant ou mot de passe est entré, vous ne pourrez pas vous connecter à la suite du projet.
!! Afin que la redirection fonctionne, il faut changer le chemin d'accès à la page sur votre machine.


Fichier "Accueil":

Le dossier "Accueil" comporte tout le projet de comweb.
On vous propose un pseudonyme à l'entrée de la page, vous pouvez choisir celui que vous voulez afin d'avoir votre pseudonyme dans le chat mais vous ne pourrez alors pas commenter.
Tout comme l'authentification, les seuls pseudonymes qui fonctionnent pour commenter sont "cir2" et "m2".
Si par mégarde vous fermez la demande de pseudonyme, il vous sera attribué l'id "cir2".
!! Un problème qui peut arriver est si vous cliquez entre les images, alors il apparaitra un undefined étant donné que l'event listener se trouve sur le div qui rassemble toutes les images dans le même bloc.


Fichier "Python":

Le dossier "Python" contient le code python permettant de lancer un serveur pour que le chat fonctionne.
!! Si vous quittez le dossier, le script s'arrêtera et le chat ne sera plus fonctionnel.
