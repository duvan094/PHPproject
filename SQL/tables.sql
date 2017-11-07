/*Name your database 'wouldYouRatherDB' in PHPmyAdmin for everything to work*/
Create table Countries(
  countryId INT NOT NULL AUTO_INCREMENT,
  countryName varchar(50) NOT NULL UNIQUE,
  Primary key(countryId)
)engine = innodb;

/*Please add more countries*/
Insert into Countries (countryName) values
("Sweden"),("Norway"),("Finland"),("Denmark"),
("Island"),("Germany"),("Uruguay"),("Japan"),
("Somalia"),("Mexico"),("France"),("Australia"),
("UK"),("Bulgaria"),("Belgium"),("Canada"),("Egypt"),
("Greece"),("Hungary"),("Russia"),("Switzerland"),
("Latvia"),("Lithuania"),("Luxembourg"),("Monaco"),
("Moldova"),("Romania"),("Poland"),("Netherlands"),
("Nigeria"),("Singapore"),("Slovakia"),("Syria"),
("Tunisia"),("Slovenia"),("Portugal"),("Spain"),
("Morocco"),("United Kingdom"),("Lebanon"),("Austria"),
("Albania"),("Andorra"),("Armenia"),("Argentina"),
("Chile"),("China"),('Kosovo'),('Ukraine'),("Other")
;



Create table Categories(
  categoryID INT NOT NULL AUTO_INCREMENT,
  categoryName varchar(50) NOT NULL,
  Primary Key(categoryID,categoryName)
)engine = innodb;

Insert into Categories (categoryName) values
("Other"),("Adult"),("Serious"),("Friends & Family"),("Casual"),("Mixed"),("Dark"),("Party")
;

Create table Users(
  userId INT NOT NULL AUTO_INCREMENT,
  username varchar(50) NOT NULL UNIQUE,
  password varchar(50) NOT NULL,
  countryId INT,
  Foreign Key(countryId) References Countries(countryId),
  Primary Key(userId)
)engine = innodb;

Insert into Users (username,password,countryId) values
("jacobi94","3da541559918a808c2402bba5012f6c60b27661c"/*asdf*/,"1"/*Sweden*/),
("draggen93","7110eda4d09e062aa5e4a390b0a572ac0d2c0220"/*1234*/,"1"/*Sweden*/),
("emmereck","3da541559918a808c2402bba5012f6c60b27661c"/*asdf*/,"2"/*Norway*/),
("mirre95","3da541559918a808c2402bba5012f6c60b27661c"/*asdf*/,"1"/*Sweden*/)
;

Create table Cards(
  cardId INT NOT NULL AUTO_INCREMENT,
  title varchar(30) NOT NULL UNIQUE,
  alt1 varchar(100) NOT NULL,
  alt2 varchar(100) NOT NULL,
  userId INT NOT NULL,
  alt1Count INT DEFAULT 0,
  alt2Count INT DEFAULT 0,
  rating INT DEFAULT 0,
  categoryId INT DEFAULT 1,
  dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
  Foreign Key(userId) References Users(userId),
  Foreign Key(categoryId) References Categories(categoryID),
  Primary Key(cardId)
)engine = innodb;


Insert into Cards (title,alt1,alt2,userId,categoryID) values
("Naughty Hitler","Kill Hitler","Slap Hitler",1,5),
("Fruity Dilemmas","Eat a Fruit","Don&#39;t",1,5),
("Drink Preference","Beer","Wine",1,5),
("Love Hurts","Loved and lost","Never loved at all",1,5),
("Easy Choices","Be a Nickleback fan","Die an early death",1,5),
("Math is hard","Get $100 today","Get $1 a day for 200 days",1,5),
("Project Management","Be a project Manager","Be a project Owner",1,5),
("Banana Phone","Live without a phone","Live without genitals",2,5),
("Time Travel","Live 500 years ago","Live 500 years in the future",2,5),
("Useless Superpowes?","Be able to smell like anything","Make someone sneeze",3,5),
("The Cake Is A Lie","Sit on a cake and eat dick","Sit on a dick and eat cake",4,2),
("9/11 or Harambe","Revive Harambe","Prevent 9/11",4,7),
("Trust Fall","Fail to save someone during a trust fall","Have someone fail to save you during a trust fall",4,7),
("Alcoholic Dilemmas","RedBull Vodka","Gin & Tonic",4,8),
("Deadly Knowledge","Know how you will die","Know when you will die",4,8),
("Tequila or Lonliness","Tequila Shots at 2 AM","Go home alone",4,8),
("Mexican or Russian","Tequila without salt & lemon","Just Vodka",4,8),
("Awkward or Sad","Bring a girl to a boys night","Go to the movies alone",4,8)
;

/*A table to keep track on which card a user has voted for.*/
Create table CardsUsersRating(
  cardId INT NOT NULL,
  userId INT NOT NULL,
  vote INT DEFAULT 0,
  Foreign Key(cardId) References Cards(cardId),
  Foreign Key(userId) References Users(userId),
  Primary Key(cardId,userId)
)engine = innodb;

/*
Create table UserCards(
  cardId INT NOT NULL,
  userId INT NOT NULL,
  Foreign Key (cardId) References Cards(cardId),
  Foreign Key (userId) References Users(userId),
  Primary Key(cardId,userId)
)engine = innodb;
*/

Create table Comments(
  commentId INT NOT NULL AUTO_INCREMENT,
  cardId INT NOT NULL,
  comment varchar(200) NOT NULL,
  userId INT NOT NULL,
  dateAdded DATETIME DEFAULT CURRENT_TIMESTAMP,
  Foreign Key(userId) References Users(userId),
  Foreign Key(cardId) References Cards(cardId),
  Primary Key(commentId)
)engine = innodb;

/*Example how to insert a comment*/
Insert into Comments (cardId,comment,userId) values
(1,"This is a comment. OR IS IT?!",1),
(1,"This is another comment. And I concur with the previous statement ;)",2)
;

Insert into Comments (cardId,comment,userId) values
(2,"Hello, is there anyone here?!",3),
(2,"Hi, my man",2),
(2,"I also want to be a part of this",4),
(2,"Sup",1)
;

Create table Admins(
  userId INT NOT NULL,
  Foreign Key(userId) References Users(userId),
  Primary Key(userId)
)engine = innodb;


Insert into Admins (userId) values
(1/*jacobi94*/);


/*Here beneath lies examples of different SQL-selections*/

/*Example how to select all the admins*/
Create View AdminView AS
Select Users.userId, Users.username, Users.password
From Users
Join Admins ON Admins.userId = Users.userId;

/*Select users and show their country*/
Create View ShowUserCountry AS
Select Users.userId, Users.username, Countries.countryName
From Users
Join Countries ON Users.countryId = Countries.countryId;

/*Example how you can select the info used for the comments on a specific card*/
Create View CardComments AS
Select Cards.title, Users.username, Countries.countryName, Comments.comment, Comments.dateAdded, Cards.cardId, Comments.commentId
from Cards
Join Comments ON Cards.cardId = Comments.cardId
Join Users ON Users.userId = Comments.userId
Join Countries ON Users.countryId = Countries.countryId
ORDER BY Comments.dateAdded ASC
;

/*Search Card example*/
/*
Select Cards.title, Cards.alt1, Cards.alt2, Cards.alt1Count, Cards.alt2Count,
Cards.rating, Categories.categoryName, Users.username, Cards.dateAdded
from Cards
Join Users ON Users.userId = Cards.userId
Join Categories ON Cards.categoryID = Categories.categoryID
Where Cards.title Like "%hitler%";
*/
/*Search User example*/
/*Select Cards.title, Cards.alt1, Cards.alt2, Cards.alt1Count, Cards.alt2Count,
Cards.rating, Categories.categoryName, Users.username, Cards.dateAdded
from Cards
Join Users ON Users.userId = Cards.userId
Join Categories ON Cards.categoryID = Categories.categoryID
Where Users.username Like "%jacob%";
*/

Create View RandomList AS
Select Cards.title, Cards.alt1, Cards.alt2, Cards.alt1Count, Cards.alt2Count,
Cards.rating, Categories.categoryName, Users.username,Countries.countryName,Cards.dateAdded, Cards.cardId
from Cards
Join Users ON Users.userId = Cards.userId
Join Categories ON Cards.categoryID = Categories.categoryID
Join Countries ON Countries.countryId = Users.countryId
ORDER BY RAND()
;

/*A view that only shows categories that have cards assigned to them*/
Create View CategoriesView AS
Select Categories.categoryID, Categories.categoryName
from Categories
Join Cards ON Categories.categoryID = Cards.categoryID
Group By Categories.categoryID;

/*Used to find a certain card or to display all the cards*/
Create View CardsView AS
Select Cards.title, Cards.alt1, Cards.alt2, Cards.alt1Count, Cards.alt2Count,
Cards.rating, Categories.categoryName, Users.username, Countries.countryName, Cards.dateAdded, Cards.cardId
from Cards
Join Users ON Users.userId = Cards.userId
Join Categories ON Cards.categoryID = Categories.categoryID
Join Countries ON Users.countryId = Countries.countryId;
/*Users.userId = 1*/

Create View TopListView AS
Select Cards.title, Users.username, Cards.rating, Cards.cardId
from Cards
Join Users ON Users.userId = Cards.userId
ORDER BY Cards.rating DESC
LIMIT 10;/*Remove this if you want more than one row*/
