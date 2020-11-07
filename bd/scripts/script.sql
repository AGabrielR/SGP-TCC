create database SGProjetos;
use SGProjetos;

create table AreaInteresse(
idArea int primary key auto_increment,
nomeArea varchar(255)
);

create table Curso(
idCurso int primary key auto_increment,
nomeCurso varchar(255),
idCampus int,
foreign key (idCampus) references Campus(idCampus)
);

/*
alter table Curso
add idCampus int,
add foreign key (idCampus) references Campus(idCampus);
*/

create table Campus(
idCampus int primary key auto_increment,
nomeCampus varchar(255)
);

create table Aluno(
idAluno int primary key auto_increment,
nomeAluno varchar(255),
idCurso int,
idCampus int,
idArea int,
cpfAluno varchar(11),
raAluno int,
senhaAluno varchar(255),
emailAluno varchar(255) unique,
turma varchar(5),
foreign key (idCurso) references Curso(idCurso),
foreign key (idCampus) references Campus(idCampus),
foreign key (idArea) references AreaInteresse(idArea)
);

create table Professor(
idProf int primary key auto_increment,
nomeProf varchar(255),
cpfProf varchar(11),
senhaProf varchar(255),
idArea int,
idCampus int,
emailProf varchar(255) unique,
siap varchar(255) unique,
foreign key (idArea) references AreaInteresse(idArea),
foreign key (idCampus) references Campus(idCampus)
);

create table Projeto(
idProj int primary key auto_increment,
idAluno int,
idProf int,
tituloProj varchar(255),
dataIniProj date,
dataFinProj date,
resumoProj mediumtext,
fotoProj blob,
idArea int,
foreign key (idArea) references AreaInteresse(idArea),
foreign key (idAluno) references Aluno(idAluno),
foreign key (idProf) references Professor(idProf)
);
