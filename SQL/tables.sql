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
("None"),("18+"),("Serious"),("Friends & Family"),("Casual"),("Mixed"),("Other")
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
("jacobi94","asdf","1"/*Sweden*/),
("draggen93","1234","1"/*Sweden*/),
("emmereck","asdf","2"/*Norway*/),
("mirre95","asdf","1"/*Sweden*/)
;

Create table Cards(
  cardId INT NOT NULL AUTO_INCREMENT,
  title varchar(50) NOT NULL,
  alt1 varchar(200) NOT NULL,
  alt2 varchar(200) NOT NULL,
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
("Dick or Toe","Eat a dick","Suck a toe",1,5),
("Naughty Hitler","Kill Hitler","Slap Hitler",1,5)
;

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


Create table Admins(
  userId INT NOT NULL,
  Foreign Key(userId) References Users(userId),
  Primary Key(userId)
)engine = innodb;


Insert into Admins (userId) values
(1/*jacobi94*/);


/*Here beneath lies examples of different SQL-selections*/

/*Example how to select all the admins*/
Select *
From Users
Join Admins ON Admins.userId = Users.userId;

/*Select users and show their country*/
Select Users.username, Countries.countryName
From Users
Join Countries ON Users.countryId = Countries.countryId;

/*Example how you can select the info used for the comments on a specific card*/
Select Cards.title, Users.username, Comments.comment, Comments.dateAdded
from Cards
Join Comments ON Cards.cardId = Comments.cardId
Join Users ON Users.userId = Comments.userId
Where Cards.cardId = 1;


/*How to select all the info needed for a specific cards*/
Select Cards.title, Cards.alt1, Cards.alt2, Cards.alt1Count, Cards.alt2Count,
Cards.rating, Categories.categoryName, Users.username, Cards.dateAdded
from Cards
Join Users ON Users.userId = Cards.userId
Join Categories ON Cards.categoryID = Categories.categoryID;

/*How to select a random card*/
Select Cards.title, Cards.alt1, Cards.alt2, Cards.alt1Count, Cards.alt2Count,
Cards.rating, Categories.categoryName, Users.username, Cards.dateAdded
from Cards
Join Users ON Users.userId = Cards.userId
Join Categories ON Cards.categoryID = Categories.categoryID;
ORDER BY RAND()
LIMIT 1;/*Remove this if you want more than one row*/
