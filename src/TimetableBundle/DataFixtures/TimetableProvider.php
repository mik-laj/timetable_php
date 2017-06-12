<?php

namespace TimetableBundle\DataFixtures;


use Faker\Provider\Base;

class TimetableProvider
{
    const SUBJECT_PROVIDER = [
        'Business analytics',
        'Data analysis',
        'Business intelligence',
        'Data engineering',
        'Econometrics',
        'Computer science',
        'Artificial intelligence',
        'Quant',
        'Six sigma',
        'Operations researc',
        'HPC',
        'Actuarial sciences',
        'Mathematical optimization',
        'Industrial statistics',
        'Statistics',
        'Predictive modeling',
        'Data mining',
        'Machine learning',
        "Physical",
        "Chemical kinetics",
        "Chemical physics",
        "Nuclear chemistry",
        "Electrochemistry",
        "Femtochemistry",
        "Geochemistry",
        "Photochemistry",
        "Quantum chemistry",
        "Solid-state chemistry",
        "Spectroscopy",
        "Surface science",
        "Thermochemistry",
        "Biochemistry",
        "Bioorganic chemistry",
        "Biophysical chemistry",
        "Chemical biology",
        "Clinical chemistry",
        "Fullerene chemistry",
        "Medicinal chemistry",
        "Neurochemistry",
        "Pharmacy",
        "Physical organic chemistry",
        "Polymer chemistry",
        "Bioinorganic chemistry",
        "Cluster chemistry",
        "Coordination chemistry",
        "Materials science",
        "Organometallic chemistry",
        "Actinide chemistry",
        "Analytical chemistry",
        "Astrochemistry",
        "Chemistry education",
        "Clay chemistry",
        "Click chemistry",
        "Computational chemistry",
        "Cosmochemistry",
        "Environmental chemistry",
        "Food chemistry",
        "Forensic chemistry",
        "Green chemistry",
        "Post-mortem chemistry",
        "Supramolecular chemistry",
        "Theoretical chemistry",
        "Wet chemistry",
        "Physical science",
        "Space science",
        "Earth science",
        "Life sciences"
    ];

    function subject() {
        return Base::randomElement(self::SUBJECT_PROVIDER);
    }
}