/*Name your database 'wouldYouRatherDB' in PHPmyAdmin for everything to work*/
Create table Countries(
  countryId INT NOT NULL AUTO_INCREMENT,
  countryName varchar(50) NOT NULL,
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
("Chile"),("China"),("Other")
;


Create table Categories(
  categoryID INT NOT NULL AUTO_INCREMENT,
  categoryName varchar(50) NOT NULL,
  Primary Key(categoryID,categoryName)
)engine = innodb;

Insert into Categories (categoryName) values
("18+"),("Serious"),("Friends & Family"),("Casual"),("Mixed"),("Other")
;

Create table Users(
  userId INT NOT NULL AUTO_INCREMENT,
  username varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  countryId INT,
  Foreign Key(countryId) References Countries(countryId),
  Primary Key(userId)
)engine = innodb;


Create table Cards(
  cardId INT NOT NULL AUTO_INCREMENT,
  alt1 varchar(200) NOT NULL,
  alt2 varchar(200) NOT NULL,
  userId INT NOT NULL,
  alt1Count INT DEFAULT 0,
  alt2Count INT DEFAULT 0,
  rating INT DEFAULT 0,
  categoryId INT,
  dateAdded DATE NOT NULL,
  Foreign Key(userId) References Users(userId),
  Foreign Key(categoryId) References Categories(categoryID),
  Primary Key(cardId)
)engine = innodb;

Create table Comments(
  commentId INT NOT NULL AUTO_INCREMENT,
  cardId INT NOT NULL,
  comment varchar(200) NOT NULL,
  userId INT NOT NULL,
  dateAdded DATE NOT NULL,
  Foreign Key(userId) References Users(userId),
  Foreign Key(cardId) References Cards(cardId),
  Primary Key(commentId)
)engine = innodb;

Create table Admins(
  userId INT NOT NULL,
  Foreign Key(userId) References Users(userId),
  Primary Key(userId)
)engine = innodb;
