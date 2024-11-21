-- Création de la base de données
CREATE DATABASE SuiviAbsences;
USE SuiviAbsences;

-- Table T_Classe
CREATE TABLE T_Classe (
    CodeClasse INT PRIMARY KEY,
    NomClasse VARCHAR(255),
    CodeGroupe INT,
    CodeDepartement INT
);

-- Table T_Groupe
CREATE TABLE T_Groupe (
    CodeGroupe INT PRIMARY KEY,
    NomGroupe VARCHAR(255)
);

-- Table T_Departement
CREATE TABLE T_Departement (
    CodeDepartement INT PRIMARY KEY,
    NomDepartement VARCHAR(255)
);

-- Table T_Grade
CREATE TABLE T_Grade (
    CodeGrade INT PRIMARY KEY,
    NomGrade VARCHAR(255)
);

-- Table T_Enseignant
CREATE TABLE T_Enseignant (
    CodeEnseignant INT PRIMARY KEY,
    Nom VARCHAR(255),
    Prenom VARCHAR(255),
    DateRecrutement DATE,
    Adresse VARCHAR(255),
    Mail VARCHAR(255),
    Tel VARCHAR(15),
    CodeDepartement INT,
    CodeGrade INT,
    FOREIGN KEY (CodeDepartement) REFERENCES T_Departement(CodeDepartement),
    FOREIGN KEY (CodeGrade) REFERENCES T_Grade(CodeGrade)
);

-- Table T_Etudiant
CREATE TABLE T_Etudiant (
    CodeEtudiant INT PRIMARY KEY,
    Nom VARCHAR(255),
    Prenom VARCHAR(255),
    DateNaissance DATE,
    CodeClasse INT,
    NumInscription VARCHAR(50),
    Adresse VARCHAR(255),
    Mail VARCHAR(255),
    Tel VARCHAR(15),
    FOREIGN KEY (CodeClasse) REFERENCES T_Classe(CodeClasse)
);

-- Table T_Matiere
CREATE TABLE T_Matiere (
    CodeMatiere INT PRIMARY KEY,
    NomMatiere VARCHAR(255),
    NbreHeureCoursParSemaine INT,
    NbreHeureTDParSemaine INT,
    NbreHeureTPParSemaine INT
);

-- Table T_Seance
CREATE TABLE T_Seance (
    CodeSeance INT PRIMARY KEY,
    NomSeance VARCHAR(255),
    HeureDebut TIME,
    HeureFin TIME
);

-- Table T_FicheAbsence
CREATE TABLE T_FicheAbsence (
    CodeFicheAbsence INT PRIMARY KEY,
    DateJour DATE,
    CodeMatiere INT,
    CodeEnseignant INT,
    CodeClasse INT,
    FOREIGN KEY (CodeMatiere) REFERENCES T_Matiere(CodeMatiere),
    FOREIGN KEY (CodeEnseignant) REFERENCES T_Enseignant(CodeEnseignant),
    FOREIGN KEY (CodeClasse) REFERENCES T_Classe(CodeClasse)
);

-- Table T_FicheAbsenceSeance
CREATE TABLE T_FicheAbsenceSeance (
    CodeFicheAbsence INT,
    CodeSeance INT,
    PRIMARY KEY (CodeFicheAbsence, CodeSeance),
    FOREIGN KEY (CodeFicheAbsence) REFERENCES T_FicheAbsence(CodeFicheAbsence),
    FOREIGN KEY (CodeSeance) REFERENCES T_Seance(CodeSeance)
);

-- Table T_LigneFicheAbsence
CREATE TABLE T_LigneFicheAbsence (
    CodeFicheAbsence INT,
    CodeEtudiant INT,
    PRIMARY KEY (CodeFicheAbsence, CodeEtudiant),
    FOREIGN KEY (CodeFicheAbsence) REFERENCES T_FicheAbsence(CodeFicheAbsence),
    FOREIGN KEY (CodeEtudiant) REFERENCES T_Etudiant(CodeEtudiant)
);
