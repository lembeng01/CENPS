document.addEventListener("DOMContentLoaded", () => {
  // Background Slider for Home Page (if applicable)
  const header = document.querySelector("header#home");
  if (header) {
    const images = ["student0.jpg", "student1.jpg", "student2.jpg", "student3.jpg", "student4.jpg"];
    let currentIndex = 0;
    setInterval(() => {
      header.style.backgroundImage = `url('${images[currentIndex]}')`;
      currentIndex = (currentIndex + 1) % images.length;
    }, 3000);
  }
  
  // Translations Object for English and French (applies to all pages)
  const translations = {
    en: {
      page_title: "Crystal English Nursery & Primary School | Home",
      language_button: "Français",
      hero_title: "Welcome to Crystal English Nursery & Primary School",
      hero_subtitle: "Inspiring Future Leaders with Innovation & Care",
      hero_button: "Discover Our Story",
      nav_home: "Home",
      nav_about: "About Us",
      nav_programs: "Programs",
      nav_admissions: "Admissions",
      nav_tuition: "Tuition",
      nav_contact: "Contact",
      nav_admin: "Administration",
      intro_heading: "Excellence in Education Since 2007",
      intro_text: "Crystal English Nursery & Primary School has been a pioneer in nurturing creativity, discipline, and academic excellence.",
      curriculum_heading: "Our St. Francis Program",
      curriculum_text1: "From Primary through Upper School, the St. Francis program sparks discovery, builds resilience, inspires faith, and deepens empathy.",
      curriculum_text2: "At every level, our carefully designed curriculum blends increased independence with collaboration and subject-matter mastery with curiosity-driven exploration. In Primary School, children learn science while making rainbows with flashlights and prisms. In Lower School, artistry and entrepreneurship come together as students write, publish, and “sell” their own books. Middle School students learn from visiting NASA engineers as they plan imaginative yet plausible trips to Mars.",
      curriculum_text3: "Our program culminates in Upper School, where students build their engineering, computer science, and artistic skills; plan and perform full-scale theatre productions; and gain real-world expertise through meaningful internships and service opportunities.",
      curriculum_text4: "We invite you to delve into our Primary School, Lower School, Middle School, and Upper School curricula. If you have questions, or you’re ready for your next steps, please contact our admissions office.",
      about_heading: "About Crystal English School",
      about_subheading: "Our Mission, Vision, and Values",
      about_text1: "Established in September 2007 by a group of visionary educators, our school has grown into a beacon of quality education. We provide a holistic curriculum that nurtures academic excellence, creativity, and character development.",
      about_text2: "Our dedicated team of teachers and staff are committed to creating a safe, inclusive, and stimulating environment that empowers students to excel and become future leaders.",
      about_text3: "Our modern classrooms are designed to promote creativity and collaboration. Students have access to innovative learning tools and resources that enhance their educational experience.",
      programs_heading: "Our Programs",
      programs_subheading: "Empowering students through diverse learning opportunities",
      programs_academic_heading: "Academic Excellence",
      programs_academic_text: "Our rigorous academic curriculum prepares students for future challenges while fostering critical thinking and problem-solving skills.",
      programs_enrichment_heading: "Enrichment Activities",
      programs_enrichment_text: "From art and music to sports and drama, our enrichment programs ensure students explore their creative potential.",
      programs_technology_heading: "Technology Integration",
      programs_technology_text: "We embrace modern technologies to enhance the learning experience, offering state-of-the-art computer labs and multimedia classrooms.",
      admissions_heading: "Admissions",
      admissions_subheading: "Join our community of lifelong learners",
      admissions_info: "We welcome applications from enthusiastic learners and their families. Please review our admission requirements and fill out the online application form below.",
      admissions_requirements_heading: "Admission Requirements",
      admissions_req1: "Completed Application Form",
      admissions_req2: "Birth Certificate",
      admissions_req3: "Previous School Records (if applicable)",
      admissions_req4: "Medical Report",
      admissions_req5: "Passport-Sized Photographs",
      admissions_form_heading: "Apply Online",
      admissions_form_label_name: "Full Name:",
      admissions_form_label_email: "Email:",
      admissions_form_label_phone: "Phone Number:",
      admissions_form_label_grade: "Grade Applying For:",
      admissions_form_option_nursery: "Nursery",
      admissions_form_option_primary1: "Primary 1",
      admissions_form_option_primary2: "Primary 2",
      admissions_form_option_primary3: "Primary 3",
      admissions_form_option_primary4: "Primary 4",
      admissions_form_option_primary5: "Primary 5",
      admissions_form_option_primary6: "Primary 6",
      admissions_form_label_message: "Additional Information:",
      admissions_form_button: "Submit Application",
      tuition_heading: "Tuition & Payment Options",
      tuition_subheading: "High-quality education at affordable rates",
      tuition_info: "At Crystal English Nursery & Primary School, we believe in accessible education. Our tuition fees are structured to provide exceptional value while supporting academic excellence.",
      tuition_payment_plans_heading: "Payment Plans",
      tuition_payment_plans_text: "We offer flexible payment plans, including termly payments, annual payments (with discounts), and installment options.",
      tuition_includes_heading: "What’s Included?",
      tuition_includes_text: "Our tuition covers high-quality classroom instruction, multimedia learning resources, library access, and extracurricular activities.",
      tuition_financial_assistance_heading: "Financial Assistance",
      tuition_financial_assistance_text: "We provide scholarship opportunities and financial aid for qualifying families. Please contact our administration office for more information.",
      tuition_make_payment_heading: "Make a Payment",
      tuition_make_payment_text: "Pay tuition securely using MTN Mobile Money or Orange Money.",
      tuition_mtn_info: "MTN MoMo: Dial *126# and enter YOUR NUMBER",
      tuition_orange_info: "Orange Money: Dial *150# and enter YOUR NUMBER",
      tuition_payment_instructions: "After payment, send proof to info@cenaps.com or via WhatsApp to +237 XXX XXX XXX",
      contact_heading: "Contact Us",
      contact_subheading: "We're here to help",
      contact_info: "Email: info@cenaps.com | Phone: +123 456 7890 | Address: 123 Learning Street, Douala, Cameroon",
      contact_form_heading: "Send Us a Message",
      contact_form_label_name: "Name:",
      contact_form_label_email: "Email:",
      contact_form_label_message: "Message:",
      contact_form_button: "Send Message",
      footer_contact_heading: "Contact Us",
      footer_contact_info: "Email: info@cenaps.com | Phone: +123 456 7890",
      footer_contact_address: "Address: 123 Learning Street, Douala, Cameroon",
      footer_copyright: "© 2025 Crystal English Nursery & Primary School. All Rights Reserved."
    },
    fr: {
      page_title: "Crystal English Nursery & Primary School | Accueil",
      language_button: "English",
      hero_title: "Bienvenue à Crystal English Nursery & Primary School",
      hero_subtitle: "Inspirer les futurs leaders avec innovation et soin",
      hero_button: "Découvrez notre histoire",
      nav_home: "Accueil",
      nav_about: "À propos",
      nav_programs: "Programmes",
      nav_admissions: "Admissions",
      nav_tuition: "Frais de scolarité",
      nav_contact: "Contact",
      nav_admin: "Administration",
      intro_heading: "L'excellence éducative depuis 2007",
      intro_text: "Crystal English Nursery & Primary School est pionnier dans la promotion de la créativité, de la discipline et de l'excellence académique.",
      curriculum_heading: "Notre Programme St. Francis",
      curriculum_text1: "De l'école primaire jusqu'au lycée, le programme St. Francis éveille la découverte, renforce la résilience, inspire la foi et approfondit l'empathie.",
      curriculum_text2: "À chaque niveau, notre programme soigneusement conçu allie indépendance accrue et collaboration, ainsi que maîtrise des matières et exploration guidée par la curiosité. À l'école primaire, les enfants apprennent la science en créant des arcs-en-ciel avec des lampes de poche et des prismes. Au cycle inférieur, l'art et l'entrepreneuriat se conjuguent lorsque les élèves écrivent, publient et « vendent » leurs propres livres. Les collégiens apprennent auprès d'ingénieurs de la NASA en planifiant des voyages imaginatifs mais plausibles vers Mars.",
      curriculum_text3: "Notre programme culmine au lycée, où les élèves développent leurs compétences en ingénierie, informatique et arts; planifient et réalisent des productions théâtrales à grande échelle; et acquièrent une expertise réelle grâce à des stages significatifs et des opportunités de service.",
      curriculum_text4: "Nous vous invitons à explorer nos cursus de l'école primaire, du cycle inférieur, du collège et du lycée. Si vous avez des questions ou si vous êtes prêts pour la suite, contactez notre bureau des admissions.",
      about_heading: "À propos de Crystal English School",
      about_subheading: "Notre Mission, Vision et Valeurs",
      about_text1: "Créée en septembre 2007 par un groupe d'éducateurs visionnaires, notre école est devenue un phare de qualité éducative. Nous offrons un cursus holistique qui favorise l'excellence académique, la créativité et le développement du caractère.",
      about_text2: "Notre équipe dévouée d'enseignants et de personnels s'engage à créer un environnement sûr, inclusif et stimulant qui permet aux élèves d'exceller et de devenir les leaders de demain.",
      about_text3: "Nos salles de classe modernes sont conçues pour encourager la créativité et la collaboration. Les élèves ont accès à des outils d'apprentissage innovants et des ressources qui enrichissent leur expérience éducative.",
      programs_heading: "Nos Programmes",
      programs_subheading: "Favoriser l'apprentissage diversifié pour nos élèves",
      programs_academic_heading: "Excellence Académique",
      programs_academic_text: "Notre programme académique rigoureux prépare les élèves aux défis futurs tout en favorisant la pensée critique et la résolution de problèmes.",
      programs_enrichment_heading: "Activités d'Enrichissement",
      programs_enrichment_text: "De l'art à la musique, en passant par le sport et le théâtre, nos activités d'enrichissement permettent aux élèves d'explorer leur potentiel créatif.",
      programs_technology_heading: "Intégration Technologique",
      programs_technology_text: "Nous adoptons les technologies modernes pour améliorer l'expérience d'apprentissage, avec des laboratoires informatiques de pointe et des salles multimédias.",
      admissions_heading: "Admissions",
      admissions_subheading: "Rejoignez notre communauté d'apprenants",
      admissions_info: "Nous accueillons les candidatures d'apprenants enthousiastes et de leurs familles. Veuillez consulter nos conditions d'admission et remplir le formulaire ci-dessous.",
      admissions_requirements_heading: "Conditions d'admission",
      admissions_req1: "Formulaire de candidature rempli",
      admissions_req2: "Certificat de naissance",
      admissions_req3: "Relevés scolaires (le cas échéant)",
      admissions_req4: "Rapport médical",
      admissions_req5: "Photos d'identité",
      admissions_form_heading: "Postulez en ligne",
      admissions_form_label_name: "Nom complet :",
      admissions_form_label_email: "Email :",
      admissions_form_label_phone: "Téléphone :",
      admissions_form_label_grade: "Niveau souhaité :",
      admissions_form_option_nursery: "Maternelle",
      admissions_form_option_primary1: "Primaire 1",
      admissions_form_option_primary2: "Primaire 2",
      admissions_form_option_primary3: "Primaire 3",
      admissions_form_option_primary4: "Primaire 4",
      admissions_form_option_primary5: "Primaire 5",
      admissions_form_option_primary6: "Primaire 6",
      admissions_form_label_message: "Informations complémentaires :",
      admissions_form_button: "Soumettre la candidature",
      tuition_heading: "Frais de scolarité",
      tuition_subheading: "Une éducation de qualité à des tarifs abordables",
      tuition_info: "À Crystal English Nursery & Primary School, nous croyons en une éducation accessible. Nos frais de scolarité sont structurés pour offrir une valeur exceptionnelle tout en soutenant l'excellence académique.",
      tuition_payment_plans_heading: "Plans de paiement",
      tuition_payment_plans_text: "Nous proposons des plans de paiement flexibles, incluant des paiements trimestriels, annuels (avec des réductions) et des options d'échelonnement.",
      tuition_includes_heading: "Ce qui est inclus",
      tuition_includes_text: "Nos frais couvrent une instruction en classe de haute qualité, des ressources multimédias, l'accès à la bibliothèque et des activités parascolaires.",
      tuition_financial_assistance_heading: "Aide financière",
      tuition_financial_assistance_text: "Nous offrons des opportunités de bourses et une aide financière pour les familles éligibles. Veuillez contacter notre bureau des admissions pour plus d'informations.",
      tuition_make_payment_heading: "Effectuez un paiement",
      tuition_make_payment_text: "Payez vos frais en toute sécurité via MTN Mobile Money ou Orange Money.",
      tuition_mtn_info: "MTN MoMo: Composez *126# et entrez VOTRE NUMÉRO",
      tuition_orange_info: "Orange Money: Composez *150# et entrez VOTRE NUMÉRO",
      tuition_payment_instructions: "Après le paiement, envoyez la preuve à info@cenaps.com ou via WhatsApp au +237 XXX XXX XXX",
      contact_heading: "Contact Us",
      contact_subheading: "We're here to help",
      contact_info: "Email: info@cenaps.com | Phone: +123 456 7890 | Address: 123 Learning Street, Douala, Cameroon",
      contact_form_heading: "Send Us a Message",
      contact_form_label_name: "Name:",
      contact_form_label_email: "Email:",
      contact_form_label_message: "Message:",
      contact_form_button: "Send Message",
      footer_contact_heading: "Contact Us",
      footer_contact_info: "Email: info@cenaps.com | Phone: +123 456 7890",
      footer_contact_address: "Address: 123 Learning Street, Douala, Cameroon",
      footer_copyright: "© 2025 Crystal English Nursery & Primary School. All Rights Reserved."
    }
  };

  // Check localStorage for saved language; default to "en"
  let currentLanguage = localStorage.getItem("language") || "en";
  
  // Function to update all elements with data-translate attribute
  function translatePage(lang) {
    document.title = translations[lang].page_title;
    const elements = document.querySelectorAll("[data-translate]");
    elements.forEach(el => {
      const key = el.getAttribute("data-translate");
      if (translations[lang][key]) {
        el.textContent = translations[lang][key];
      }
    });
  }
  
  // Define flag image URLs
  const frenchFlagURL = "https://upload.wikimedia.org/wikipedia/en/c/c3/Flag_of_France.svg";
  const englishFlagURL = "https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom.svg";
  
  const toggleButton = document.getElementById("language-toggle");
  toggleButton.addEventListener("click", () => {
    currentLanguage = (currentLanguage === "en") ? "fr" : "en";
    localStorage.setItem("language", currentLanguage);
    translatePage(currentLanguage);
    const flagImg = toggleButton.querySelector("img");
    flagImg.src = (currentLanguage === "en") ? englishFlagURL : frenchFlagURL;
  });
  
  // Initial translation on page load
  translatePage(currentLanguage);
  const flagImg = toggleButton.querySelector("img");
  flagImg.src = (currentLanguage === "en") ? englishFlagURL : frenchFlagURL;
  
  // Navigation Active State Handling
  const navLinks = document.querySelectorAll("nav ul li a");
  navLinks.forEach(link => {
    link.addEventListener("click", function() {
      navLinks.forEach(link => link.classList.remove("active"));
      this.classList.add("active");
    });
  });
  
  // -----------------------------
  // Supabase Integration for Admissions Form
  const supabaseUrl = 'https://rlejemjqprjlvfomgmev.supabase.co';  // Replace with your Supabase URL
  const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInRlciI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InJsZWplbWpxcHJqbHZmb21nbWV2Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDEzOTQzOTQsImV4cCI6MjA1Njk3MDM5NH0.r0zafR0VmQVZFuczBPubIEJK94b5DHV6VkYueQBnuUY';
  const supabaseClient = supabase.createClient(supabaseUrl, supabaseKey);

  async function submitAdmission(data) {
    const { data: insertedData, error } = await supabaseClient
      .from('admissions')
      .insert([data]);
    
    if (error) {
      console.error('Error inserting admission data:', error);
      alert("There was an error submitting your admission. Please try again.");
    } else {
      console.log('Admission submitted successfully:', insertedData);
      alert("Admission submitted successfully!");
    }
  }
  window.submitAdmission = submitAdmission;

  // Handle Admissions Form Submission (if form exists)
  const admissionsForm = document.getElementById("admissions-form");
  if (admissionsForm) {
    admissionsForm.addEventListener("submit", function(e) {
      e.preventDefault();
      const admissionData = {
        fullName: document.getElementById("name").value,
        email: document.getElementById("email").value,
        phone: document.getElementById("phone").value,
        grade: document.getElementById("grade").value,
        message: document.getElementById("message").value,
        submittedAt: new Date().toISOString()
      };
      submitAdmission(admissionData);
      admissionsForm.reset();
    });
  }
});
