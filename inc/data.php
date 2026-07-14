<?php
/**
 * Static content data layer — converted from src/data/data.json, blog.ts,
 * faq.ts and overall.ts. All site copy lives here as plain PHP arrays so
 * pages stay free of inline content and can be updated in one place.
 */

// ---------------------------------------------------------------------
// Navigation (from data.json)
// ---------------------------------------------------------------------
$navLinks = [
    ['label' => 'FIXED PRICES', 'href' => '/fixed-prices.php'],
    ['label' => 'PRACTICE AREA', 'href' => '/practice-area.php'],
    ['label' => 'NEWS & BLOG', 'href' => '/blogs.php'],
    ['label' => 'Q&A', 'href' => '/faqs.php'],
    ['label' => 'CONTACT', 'href' => '/contact.php'],
];

$lawLinks = [
    ['label' => 'Business Law', 'href' => '/practice-area.php?slug=business-law'],
    ['label' => 'Commercial Law', 'href' => '/practice-area.php?slug=commercial-law'],
    ['label' => 'Criminal Law', 'href' => '/practice-area.php?slug=criminal-law'],
    ['label' => 'Debt Recovery', 'href' => '/practice-area.php?slug=debt-recovery'],
    ['label' => 'Family Law', 'href' => '/practice-area.php?slug=family-law'],
    ['label' => 'Immigration Law', 'href' => '/practice-area.php?slug=immigration-law'],
];

$usefulLinks = [
    ['label' => 'Privacy Policy', 'href' => '/privacy-policy.php'],
    ['label' => 'Terms & Conditions', 'href' => '/terms-and-conditions.php'],
    ['label' => 'Disclaimer', 'href' => '/disclaimer.php'],
];

// ---------------------------------------------------------------------
// FAQ (src/data/faq.ts)
// ---------------------------------------------------------------------
$consultationCostFAQ = [
    ['question' => 'Do you assist with visa applications?', 'answer' => 'Yes, we handle work, student, and family visa cases.'],
    ['question' => 'Can you help with deportation defense?', 'answer' => 'Absolutely. Our team provides full legal representation.'],
    ['question' => 'Do you assist with visa applications?', 'answer' => 'Yes, we handle work, student, and family visa cases.'],
    ['question' => 'Can you help with deportation defense?', 'answer' => 'Absolutely. Our team provides full legal representation.'],
    ['question' => 'Do you assist with visa applications?', 'answer' => 'Yes, we handle work, student, and family visa cases.'],
    ['question' => 'Can you help with deportation defense?', 'answer' => 'Absolutely. Our team provides full legal representation.'],
    ['question' => 'Do you assist with visa applications?', 'answer' => 'Yes, we handle work, student, and family visa cases.'],
    ['question' => 'Can you help with deportation defense?', 'answer' => 'Absolutely. Our team provides full legal representation.'],
];

// ---------------------------------------------------------------------
// Blog posts (src/data/blog.ts -> `blogs` export; the unused legacy
// `blog` export was dead code and has been dropped, see migration notes)
// ---------------------------------------------------------------------
$blogs = [
    [
        'id' => 1,
        'title' => 'Navigating Family Law in Australia: What You Need to Know',
        'tags' => ['Transformation', 'Machine Learning'],
        'category' => 'Business Law',
        'image' => '/assets/images/family-law.webp',
        'excerpt' => 'Family law issues are often among the most emotionally and legally challenging experiences a person can face. At DM Legal Services, we understand that every family situation is unique, and we provide clients with expert guidance to navigate divorce, child custody disputes, spousal support, and property settlements with confidence and clarity. Australia’s family law system prioritises the best interests of children while also ensuring that adults receive fair and equitable resolutions.',
        'author' => [
            'name' => 'Khilendra Raj Timalsina',
            'role' => 'AI Researcher & Content Strategist',
            'date' => 'July 12, 2024',
            'avatar' => '/assets/images/user.png',
            'readTime' => '4 Min Read',
        ],
        'featuredImage' => '/assets/images/featuredpostimg1.png',
        'sections' => [
            ['id' => 'introduction', 'heading' => 'Navigating Family Law in Australia: What You Need to Know', 'content' => "Family law issues are often among the most emotionally and legally challenging experiences a person can face. At DM Legal Services, we understand that every family situation is unique, and we provide clients with expert guidance to navigate divorce, child custody disputes, spousal support, and property settlements with confidence and clarity. Australia’s family law system prioritises the best interests of children while also ensuring that adults receive fair and equitable resolutions. Understanding the legal framework and your rights is essential to protecting your family’s wellbeing and achieving the most favourable outcomes. Our experienced family lawyers work closely with clients to evaluate their circumstances, provide practical advice, and develop tailored strategies that address both legal and emotional considerations."],
            ['id' => 'ai-role', 'heading' => 'Business Law Essentials: Protecting Your Company in Australia', 'content' => 'Operating a business in Australia involves many legal duties, possible risks, and rules that must be followed to run a company smoothly and lawfully. DM Legal Services offers clear and practical business law support to help business owners protect their businesses, understand their responsibilities, and handle legal issues with confidence. Whether you are planning to start a new business, already running a company, or dealing with important business changes, having a good understanding of the law is essential for long-term success. Our experienced business lawyers provide guidance in all major areas of commercial law, including writing and reviewing contracts, buying or selling businesses, company structure changes, and meeting Australian corporate and regulatory requirements.'],
            ['id' => 'automating-incident-response', 'heading' => 'Immigration Law Made Simple: Expert Guidance for Moving to Australia', 'content' => 'Navigating the Australian immigration system can be a complex and time-consuming process. With a multitude of visa types, strict eligibility criteria, and ever-changing regulations, securing approval requires detailed knowledge, careful preparation, and strategic planning. At DM Legal Services, we simplify the immigration process for individuals and families, ensuring every application is accurate, complete, and optimised for success. Our team provides personalised guidance across a wide range of immigration matters, including family visas, skilled migration, student visas, business visas, and temporary work permits.'],
        ],
        'featuredPost' => [
            ['title' => 'AI-Powered Cybersecurity: The Future of Digital Defense', 'author' => 'Khilendra Raj Timalsina', 'date' => 'June 12, 2024', 'image' => '/assets/images/featuredpostimg1.png'],
            ['title' => 'AI-Powered Cybersecurity: The Future of Digital Defense', 'author' => 'Khilendra Raj Timalsina', 'date' => 'June 12, 2024', 'image' => '/assets/images/featuredpostimg1.png'],
        ],
    ],
    [
        'id' => 2,
        'title' => 'Business Law Essentials: Protecting Your Company in Australia',
        'tags' => ['Transformation', 'Machine Learning'],
        'category' => 'Family & Personal Law',
        'image' => '/assets/images/business-law.jpg',
        'excerpt' => 'Operating a business in Australia involves many legal duties, possible risks, and rules that must be followed to run a company smoothly and lawfully. DM Legal Services offers clear and practical business law support to help business owners protect their businesses, understand their responsibilities, and handle legal issues with confidence.',
        'author' => [
            'name' => 'Khilendra Raj Timalsina',
            'role' => 'AI Researcher & Content Strategist',
            'date' => 'July 12, 2024',
            'avatar' => '/assets/images/user.png',
            'readTime' => '4 Min Read',
        ],
        'featuredImage' => '/assets/images/featuredpostimg1.png',
        'sections' => [
            ['id' => 'introduction', 'heading' => 'Introduction: The Rise of AI in Cybersecurity', 'content' => 'In an era where digital transformation shapes the way we live, work, and connect, cybersecurity has emerged as a critical priority. The proliferation of sophisticated cyber threats, from ransomware and phishing to state-sponsored attacks, has pushed traditional defenses to their limits. AI offers advanced capabilities that extend beyond human capacity, enabling organizations to identify, prevent, and respond to threats with unprecedented speed and precision.'],
            ['id' => 'ai-role', 'heading' => 'AI’s Role in Threat Detection and Prevention', 'content' => 'By leveraging machine learning, natural language processing, and behavioral analytics, AI-powered tools can analyze vast amounts of data, detect anomalies, and predict potential vulnerabilities before they are exploited. The rise of AI in cybersecurity is not merely a trend but a necessary evolution.'],
            ['id' => 'automating-incident-response', 'heading' => 'Automating Incident Response', 'content' => 'As attackers themselves adopt AI to enhance their strategies, defenders must harness the power of this technology to stay ahead of an ever-changing threat landscape, building a safer digital ecosystem for clients and businesses alike.'],
        ],
        'featuredPost' => [
            ['title' => 'AI-Powered Cybersecurity: The Future of Digital Defense', 'author' => 'Khilendra Raj Timalsina', 'date' => 'June 12, 2024', 'image' => '/assets/images/featuredpostimg1.png'],
        ],
    ],
    [
        'id' => 3,
        'title' => 'Immigration Law Made Simple: Expert Guidance for Moving to Australia',
        'tags' => ['Transformation', 'Machine Learning'],
        'category' => 'Immigration & Visas',
        'image' => '/assets/images/immigration-laws.jpg',
        'excerpt' => 'Navigating the Australian immigration system can be a complex and time-consuming process. With a multitude of visa types, strict eligibility criteria, and ever-changing regulations, securing approval requires detailed knowledge, careful preparation, and strategic planning.',
        'author' => [
            'name' => 'Khilendra Raj Timalsina',
            'role' => 'AI Researcher & Content Strategist',
            'date' => 'July 12, 2024',
            'avatar' => '/assets/images/user.png',
            'readTime' => '4 Min Read',
        ],
        'featuredImage' => '/assets/images/featuredpostimg1.png',
        'sections' => [
            ['id' => 'introduction', 'heading' => 'Introduction: Simplifying Australian Immigration', 'content' => 'At DM Legal Services, we simplify the immigration process for individuals and families, ensuring every application is accurate, complete, and optimised for success. Our team provides personalised guidance across a wide range of immigration matters.'],
            ['id' => 'ai-role', 'heading' => 'Visa Categories We Handle', 'content' => 'Family visas, skilled migration, student visas, business visas, and temporary work permits all fall within our areas of expertise, allowing us to support a wide range of client circumstances.'],
            ['id' => 'automating-incident-response', 'heading' => 'Building a Tailored Strategy', 'content' => 'We work closely with clients to understand their unique circumstances, assess eligibility, and create tailored strategies that maximise the likelihood of a positive outcome.'],
        ],
        'featuredPost' => [
            ['title' => 'AI-Powered Cybersecurity: The Future of Digital Defense', 'author' => 'Khilendra Raj Timalsina', 'date' => 'June 12, 2024', 'image' => '/assets/images/featuredpostimg1.png'],
        ],
    ],
];

// ---------------------------------------------------------------------
// Home page sections (src/data/overall.ts)
// ---------------------------------------------------------------------
$teamMembers = [];
for ($i = 1; $i <= 12; $i++) {
    $teamMembers[] = [
        'id' => $i,
        'name' => 'Kerry Aguilar',
        'role' => 'Senior Associate Team Leader, Family Law Practice',
        'image' => '/assets/images/teamimg.png',
        'overlayColor' => ($i % 2 === 1) ? 'blue' : 'gold',
    ];
}

$steps = [
    ['id' => 1, 'image' => '/assets/icons/consultation.svg', 'title' => 'Consultation & Assessment', 'description' => 'Our lawyer reviews all documents and legal aspects.'],
    ['id' => 2, 'image' => '/assets/icons/action-plan.svg', 'title' => 'Tailored Action Plan', 'description' => 'Our lawyer reviews all documents and legal aspects.'],
    ['id' => 3, 'image' => '/assets/icons/execution.svg', 'title' => 'Execution & Support', 'description' => 'Our lawyer reviews all documents and legal aspects.'],
    ['id' => 4, 'image' => '/assets/icons/resolution.svg', 'title' => 'Resolution & Outcome', 'description' => 'Our lawyer reviews all documents and legal aspects.'],
];

$fixedFeesStep = [
    ['id' => 1, 'image' => '/assets/icons/consultation.svg', 'title' => 'Transparency', 'description' => 'You always know what you will pay before we start work on your matter.'],
    ['id' => 2, 'image' => '/assets/icons/action-plan.svg', 'title' => 'Certainty', 'description' => 'Fixed fees mean no surprises, regardless of how long a matter takes.'],
    ['id' => 3, 'image' => '/assets/icons/execution.svg', 'title' => 'Value for money', 'description' => 'Transparent pricing backed by experienced, accredited specialists.'],
];

$legalServicesData = [
    [
        'id' => 1,
        'title' => 'Commercial Law',
        'description' => 'At DM Legal, we provide comprehensive commercial law services including contracts, business disputes, and corporate governance solutions to protect your business interests.',
        'image' => '/assets/images/commercial-law.png',
        'innerServiceCount' => 2,
    ],
    [
        'id' => 2,
        'title' => 'Business Law',
        'description' => 'Our business law services cover company formation, mergers, acquisitions, and business restructuring for seamless operations.',
        'image' => '/assets/images/business-law.png',
        'innerServiceCount' => 2,
    ],
    [
        'id' => 3,
        'title' => 'Criminal Law',
        'description' => 'We offer expert criminal law representation, defending clients across all levels of criminal proceedings.',
        'image' => '/assets/images/criminal-law.png',
        'innerServiceCount' => 6,
    ],
    [
        'id' => 4,
        'title' => 'Family Law',
        'description' => 'Our experienced family lawyers help you navigate divorce, custody, and other sensitive family matters with care.',
        'image' => '/assets/images/family-law.png',
        'innerServiceCount' => 2,
    ],
    [
        'id' => 5,
        'title' => 'Debt Recovery',
        'description' => 'Our debt recovery services assist businesses and individuals in recovering unpaid debts effectively.',
        'image' => '/assets/images/debt-recovery.png',
        'innerServiceCount' => 2,
    ],
    [
        'id' => 6,
        'title' => 'Immigration Law',
        'description' => 'We provide expert legal advice on visa applications, residency, citizenship, and immigration appeals.',
        'image' => '/assets/images/immigration-law.png',
        'innerServiceCount' => 2,
    ],
];
// Inner services shared by every practice area on the detail page (src/data/overall.ts InnerDropdownData)
$practiceAreaInnerServices = [
    ['id' => 1, 'title' => 'Drug Offences', 'description' => 'Whether you are charged with a minor offence like drug possession or a serious drug offence like drug supply or importation, our drug offences team will help you avoid the harshest penalties.', 'image' => '/assets/images/commercial-law.png'],
    ['id' => 2, 'title' => 'Traffic Offences', 'description' => 'Whether you are charged with a minor offence like drug possession or a serious drug offence like drug supply or importation, our traffic offences team will help you avoid the harshest penalties.', 'image' => '/assets/images/business-law.png'],
    ['id' => 3, 'title' => 'Domestic/Family Violence', 'description' => 'Our team will help you navigate domestic and family violence matters with sensitivity and strong representation.', 'image' => '/assets/images/criminal-law.png'],
    ['id' => 4, 'title' => 'Murder & Manslaughter', 'description' => 'We provide robust defence representation for the most serious criminal charges, including murder and manslaughter.', 'image' => '/assets/images/family-law.png'],
    ['id' => 5, 'title' => 'Robbery & Burglary Charges', 'description' => 'Our criminal defence team has extensive experience defending robbery and burglary charges.', 'image' => '/assets/images/debt-recovery.png'],
    ['id' => 6, 'title' => 'Firearm & Weapons Charges', 'description' => 'We defend clients facing firearm and weapons charges with strategic, evidence-based representation.', 'image' => '/assets/images/immigration-law.png'],
];

$newsItem = [
    'category' => 'Victories',
    'date' => 'April 26, 2024',
    'title' => 'Firm Victories: T-Mobile Can’t Evade Lawsuit for Employees Stealing During Phone Trade-In',
    'preview' => 'In November 2023, we filed a lawsuit against T-Mobile in Washington for its pattern and practice of violating users’ most intimate privacy. An employee at one of its retail stores stole and disseminated nude images from our client’s phone during her trade-in. We sued the wireless giant for, among other things, failing to properly train and supervise its employees.',
    'image' => '/assets/images/warningBG.png',
    'link' => '/blogs.php',
];
$newsData = array_fill(0, 6, $newsItem);

$options = [
    ['icon' => '/assets/icons/Face-to-face_icon.svg', 'label' => 'Face-to-Face'],
    ['icon' => '/assets/icons/Telefone_call_icon.svg', 'label' => 'Telephone Call'],
    ['icon' => '/assets/icons/Zoom_icom.svg', 'label' => 'Zoom'],
    ['icon' => '/assets/icons/Google_meets_icon.svg', 'label' => 'Google Meet'],
];

$affiliations = [
    ['id' => 1, 'image' => '/assets/images/doyles.png', 'alt' => 'Doyles 2016 Award'],
    ['id' => 2, 'image' => '/assets/images/doyles.png', 'alt' => 'Doyles 2017 Award'],
    ['id' => 3, 'image' => '/assets/images/doyles.png', 'alt' => 'Doyles 2018 Award'],
    ['id' => 4, 'image' => '/assets/images/doyles.png', 'alt' => 'Doyles 2019 Award'],
];

$statsData = [
    ['value' => '12+', 'label' => 'Years of Knowledge'],
    ['value' => '3000+', 'label' => 'Happy Clients'],
    ['value' => '200+', 'label' => 'Completed Cases'],
    ['value' => '300+', 'label' => 'Clients Referred Others'],
    ['value' => '100%', 'label' => 'Successful Outcome'],
];

$serviceData = [
    ['image' => '/assets/icons/personal-service.svg', 'title' => 'Personal Service', 'description' => 'We are accredited specialists and empathy for your situation to achieve a resolution quickly and fairly.'],
    ['image' => '/assets/icons/attentionToDetail.svg', 'title' => 'Attention To Detail', 'description' => 'We are accredited specialists and empathy for your situation to achieve a resolution quickly and fairly.'],
    ['image' => '/assets/icons/specialist.svg', 'title' => 'Full-Scope Legal Specialists', 'description' => 'We are accredited specialists and empathy for your situation to achieve a resolution quickly and fairly.'],
];

// ---------------------------------------------------------------------
// FAQ categories (src/data/overall.ts `categories`) — used on faqs.php
// ---------------------------------------------------------------------
$faqCategories = [
    ['title' => 'General Information', 'faqs' => [
        ['question' => 'How much does a consultation cost?', 'answer' => 'Our first consultation is free, with no obligation to proceed further.'],
        ['question' => 'Do you handle international cases?', 'answer' => 'Yes, we provide legal support for clients across Australia and overseas.'],
    ]],
    ['title' => 'Consultation', 'faqs' => [
        ['question' => 'How do I book a consultation?', 'answer' => 'You can book online through our Book a Consultation page or call us directly.'],
    ]],
    ['title' => 'Legal Services', 'faqs' => [
        ['question' => 'How much does a consultation cost?', 'answer' => 'Our first consultation is free, with no obligation to proceed further.'],
        ['question' => 'Do you handle international cases?', 'answer' => 'Yes, we provide legal support for clients across Australia and overseas.'],
    ]],
    ['title' => 'Fees & Payments', 'faqs' => [
        ['question' => 'How do I book a consultation?', 'answer' => 'You can book online through our Book a Consultation page or call us directly.'],
    ]],
    ['title' => 'Case Handling', 'faqs' => [
        ['question' => 'How much does a consultation cost?', 'answer' => 'Our first consultation is free, with no obligation to proceed further.'],
        ['question' => 'Do you handle international cases?', 'answer' => 'Yes, we provide legal support for clients across Australia and overseas.'],
    ]],
    ['title' => 'Client Support', 'faqs' => [
        ['question' => 'How do I book a consultation?', 'answer' => 'You can book online through our Book a Consultation page or call us directly.'],
    ]],
];

// ---------------------------------------------------------------------
// Practice areas overview (used on practice-area.php landing grid)
// ---------------------------------------------------------------------
$practiceAreas = [
    ['icon' => '/assets/icons/business-law.svg', 'title' => 'Business Law', 'description' => 'Protecting your business interests through every stage of commercial life.', 'slug' => 'business-law'],
    ['icon' => '/assets/icons/commercial-law.svg', 'title' => 'Commercial Law', 'description' => 'Practical, commercially-minded advice for contracts and disputes.', 'slug' => 'commercial-law'],
    ['icon' => '/assets/icons/criminal-law.svg', 'title' => 'Criminal Law', 'description' => 'Strong, experienced representation across all criminal matters.', 'slug' => 'criminal-law'],
    ['icon' => '/assets/icons/debt-recovery.svg', 'title' => 'Debt Recovery', 'description' => 'Effective recovery strategies for businesses and individuals owed money.', 'slug' => 'debt-recovery'],
    ['icon' => '/assets/icons/family-law.svg', 'title' => 'Family Law', 'description' => 'Compassionate guidance through divorce, custody, and family disputes.', 'slug' => 'family-law'],
    ['icon' => '/assets/icons/immigration-law.svg', 'title' => 'Immigration Law', 'description' => 'Expert advice on visas, residency, citizenship, and appeals.', 'slug' => 'immigration-law'],
];

// ---------------------------------------------------------------------
// Practice area detail page sections (shared across every practice area)
// ---------------------------------------------------------------------
$helpClientsData = [
    'backgroundImage' => '/assets/images/bgClient.png',
    'title' => 'How We Help Our Clients',
    'description' => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.',
    'services' => [
        ['icon' => '/assets/icons/legal-services.svg', 'title' => 'High-Quality Legal Services', 'description' => 'Tailored for small, medium, and growing businesses'],
        ['icon' => '/assets/icons/client-approach.svg', 'title' => 'Client-Centric Approach', 'description' => 'Tailored for small, medium, and growing businesses'],
        ['icon' => '/assets/icons/expertise.svg', 'title' => 'Comprehensive Expertise', 'description' => 'Tailored for small, medium, and growing businesses'],
        ['icon' => '/assets/icons/pricing.svg', 'title' => 'Transparent Pricing', 'description' => 'Tailored for small, medium, and growing businesses'],
    ],
];

$actionsData0 = [
    'title' => 'Business Law',
    'description' => "Our business law services support companies through all stages of growth and development:",
    'sub-description' => "We work with small to medium enterprises across various industries, providing strategic legal support that aligns with your business objectives.:",
    'actions' => [
        ['question' => 'Company formation and business structuring', 'answer' => 'We assist with establishing businesses and choosing the right structure..'],
        ['question' => 'Business compliance and regulatory matters', 'answer' => 'We ensure your business meets all relevant compliance and regulatory requirements.'],
        ['question' => 'Shareholder agreements and disputes', 'answer' => 'We draft and resolve disputes concerning shareholder agreements.'],
        ['question' => 'Business restructuring', 'answer' => 'We provide legal guidance for company reorganizations and restructuring.'],
        ['question' => 'Commercial disputes and litigation', 'answer' => 'We represent businesses in disputes and litigation matters.'],
        ['question' => 'Commercial disputes and litigation', 'answer' => 'We provide legal guidance for company reorganizations and restructuring.'],
        ['question' => 'Corporate governance advice', 'answer' => ' We advise on governance policies and best practices for business operations.'],
        ['question' => 'Business contract review', 'answer' => 'We review and advise on contracts to safeguard business interests.'],
    ],
    'images' => ['/assets/images/img1.png', '/assets/images/img2.png', '/assets/images/img3.png', '/assets/images/img4.png'],
];

$actionsData1 = [
    'title' => 'Commercial Law',
    'description' => "We provide comprehensive commercial law services to businesses across Sydney, including:",
    'sub-description' => "Our commercial team understands the practical realities of running a business and provides clear, actionable advice to protect your commercial interests and resolve disputes efficiently.",
    'actions' => [
        ['question' => 'Retail lease agreements and lease disputes', 'answer' => 'We build a tailored defence strategy based on the specific facts and evidence in your matter.'],
        ['question' => 'Commercial contract drafting and review', 'answer' => 'Where appropriate, we negotiate with prosecutors to achieve the most favourable outcome available.'],
        ['question' => 'Business transaction documentation', 'answer' => 'We review unfavourable outcomes for grounds of appeal and advise on the prospects of success.'],
        ['question' => 'Contract dispute resolution', 'answer' => 'We represent clients in resolving disputes efficiently and fairly.'],
        ['question' => 'Commercial negotiation and mediation', 'answer' => 'We assist with negotiations and mediations to avoid litigation when possible.'],
        ['question' => 'Lease renewal and variation matters', 'answer' => 'We provide advice and representation in lease renewals and variations.'],
        ['question' => 'Commercial tenancy issues', 'answer' => 'We guide clients through complex commercial tenancy disputes.'],
    ],
    'images' => ['/assets/images/img1.png', '/assets/images/img2.png', '/assets/images/img3.png', '/assets/images/img4.png'],
];

$actionsData2 = [
    'title' => 'Criminal Law',
    'description' => "We provide experienced criminal defence representation across all NSW courts, from Local Court matters to District and Supreme Court proceedings. Our criminal law practice covers a comprehensive range of offences:",
    'sub-description' => "We work with small to medium enterprises across various industries, providing strategic legal support that aligns with your business objectives.:",
    'actions' => [
        ['question' => 'Drug offences', 'answer' => 'We handle drug possession, trafficking, cultivation, steroid offences, proceeds of crime, and diversion programs.'],
        ['question' => 'Traffic offences', 'answer' => 'We represent clients in drink and drug driving, dangerous driving, disqualified driving, speeding, and licence appeals.'],
        ['question' => 'Domestic Violence & AVO matters', 'answer' => 'We defend against AVOs, breaches, domestic assault charges, and variation or revocation of protection orders.'],
        ['question' => 'Assault & violence offences', 'answer' => 'We handle common assault, assault occasioning actual bodily harm, affray, violent disorder, grievous bodily harm, and self-defence cases.'],
        ['question' => 'Property & theft offences', 'answer' => 'We represent clients in larceny, shoplifting, break and enter, robbery, fraud, dishonesty, and receiving stolen property cases.'],
        ['question' => 'Weapons & firearms offences', 'answer' => 'We cover unauthorised possession, prohibited weapons, public place offences, and firearms licensing matters.'],
        ['question' => 'Serious indictable offences', 'answer' => 'We provide representation for murder, manslaughter, sexual assault, serious drug supply, armed robbery, and Supreme/District Court cases.'],
        ['question' => 'Criminal defence approach', 'answer' => 'Our experienced lawyers provide strategic defence to achieve the best possible outcome, including bail, plea negotiations, trials, appeals, and mental health defences.'],
        ],
    'images' => ['/assets/images/img1.png', '/assets/images/img2.png', '/assets/images/img3.png', '/assets/images/img4.png'],
];

$actionsData3 = [
    'title' => 'Debt Recovery',
    'description' => "At DM Legal, we understand that your legal matter is important to you. Our experienced solicitors guide you through every available action, from early intervention to court representation, with a strategy tailored to your circumstances.",
    'sub-description' => "We work with clients across NSW to recover outstanding debts efficiently, balancing firm action with practical, cost-effective strategies.",
    'actions' => [
        ['question' => 'Letters of demand and formal debt collection notices', 'answer' => 'We send formal notices and manage debt recovery communications.'],
        ['question' => 'Negotiated payment arrangements', 'answer' => 'We assist in negotiating payment plans to recover debts efficiently.'],
        ['question' => 'Local Court debt recovery proceedings', 'answer' => 'We represent clients in Local Court debt recovery actions.'],
        ['question' => 'Judgment enforcement', 'answer' => 'We assist in enforcing judgments to secure debt repayment.'],
        ['question' => 'Commercial debt collection', 'answer' => 'We handle business debt recovery matters strategically.'],
        ['question' => 'Personal debt recovery', 'answer' => 'We recover personal debts while balancing cost and likelihood of success.'],
        ['question' => 'Creditors statutory demands', 'answer' => 'We prepare and manage statutory demands for creditors.'],
    ],
    'images' => ['/assets/images/img1.png', '/assets/images/img2.png', '/assets/images/img3.png', '/assets/images/img4.png'],
];

$actionsData4 = [
    'title' => 'Family Law',
    'description' => "Our family law practice specializes in complex property settlements and financial disputes in the Federal Circuit and Family Court. We provide expert representation in:",
    'sub-description' => "With extensive experience in high-value and financially complex matters, we use detailed forensic analysis to protect your interests and ensure fair property division. Our approach combines strategic negotiation with robust court representation when required.",
    'actions' => [
        ['question' => 'Property settlements and asset division', 'answer' => 'We assist clients in achieving fair and equitable division of property and assets.'],
        ['question' => 'Forensic financial analysis and asset tracing', 'answer' => 'We work with financial experts to identify, analyse, and trace complex asset structures.'],
        ['question' => 'Disclosure disputes and hidden asset investigations', 'answer' => 'We address non-disclosure issues to ensure full and transparent financial disclosure.'],
        ['question' => 'Spousal maintenance matters', 'answer' => 'We provide advice and representation in spousal maintenance applications and disputes.'],
        ['question' => 'Parenting arrangements and custody disputes', 'answer' =>  'We assist with resolving parenting arrangements in the best interests of the child.'],
        ['question' => 'Binding Financial Agreements' , 'answer' => 'We prepare and review binding financial agreements to provide financial certainty.'],
        ['question' => 'Divorce applications' , 'answer' => 'We guide clients through the divorce process efficiently and professionally.'],
    ],
    'images' => ['/assets/images/img1.png', '/assets/images/img2.png', '/assets/images/img3.png', '/assets/images/img4.png'],
];

$actionsData5 = [
    'title' => 'Immigration Law',
    'description' => "Our immigration law practice specializes in complex visa matters, Administrative Review Tribunal (ART) appeals, and Federal Circuit Court judicial review proceedings. We provide comprehensive representation across all stages of the immigration process:.",
    'sub-description' => "Early advice is critical in immigration matters – visa refusals have strict time limits for appeals (typically 21 days for ART review, 35 days for Federal Circuit Court judicial review). Contact us immediately if your visa has been refused or cancelled.",

    'actions' => [
        ['question' => 'Visa applications & renewals', 'answer' => 'We assist with partner, student, family reunion, skilled, business, temporary work, visitor, working holiday, and citizenship visas.'],
        ['question' => 'Visa refusals & character issues', 'answer' => 'We handle Section 501/116 cancellations, ministerial interventions, bridging visas, and directions 90/99 submissions.'],
        ['question' => 'ART appeals and hearings', 'answer' => 'We manage ART appeals including merit review, written submissions, witness statements, expert reports, oral submissions, and refugee/protection claims.'],
        ['question' => 'Federal Circuit Court judicial review', 'answer' => 'We provide representation for judicial review of ART decisions, including jurisdictional error, procedural fairness, and appeals.'],
        ['question' => 'Migration compliance & visa conditions', 'answer' => 'We assist with condition waivers, work rights, reporting obligations, and compliance issues.'],
        ['question' => 'Deportation & removal matters', 'answer' => 'We handle visa cancellations, revocations, detention matters, and removal proceedings.'],
        ['question' => 'Immigration law approach', 'answer' => 'We combine detailed knowledge of migration law and policy with practical advocacy skills to provide strategic representation.'],
    ],
    'images' => ['/assets/images/img1.png', '/assets/images/img2.png', '/assets/images/img3.png', '/assets/images/img4.png'],
];

// Lookup so practice-area.php can pick the right actions block by ?slug=
$actionsDataBySlug = [
    'business-law' => $actionsData0,
    'commercial-law' => $actionsData1,
    'criminal-law' => $actionsData2,
    'debt-recovery' => $actionsData3,
    'family-law' => $actionsData4,
    'immigration-law' => $actionsData5,
];


$videoSectionData = [
    'videoUrl' => '',
    'title' => 'Why You Need an Expert Lawyer — Now',
    'description' => "At DM Legal, we understand that your matter is important to you. That's why we offer comprehensive legal services to ensure that your rights and interests are protected. Our experienced solicitors will guide you through every step of the process, from initial advice to final resolution.",
    'buttonText' => 'Start Free Legal Check',
    'buttonLink' => '/contact.php',
];

$expertsSection = [
    'heading' => 'Meet the Experts Who Fought and Won',
    'subheading' => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.',
    'experts' => [
        ['name' => 'David Chen', 'role' => 'Drug Offence Specialist', 'stat' => "300+ successful defences", 'description' => 'David found details that changed everything about my case.', 'ctaText' => "See David's Case Strategy", 'ctaLink' => '#', 'image' => '/assets/images/expert1.png'],
        ['name' => 'David Chen', 'role' => 'Criminal Defence Lead', 'stat' => '25 years courtroom experience', 'description' => 'David found details that changed everything about my case.', 'ctaText' => "Review David's Case History", 'ctaLink' => '#', 'image' => '/assets/images/expert2.png'],
        ['name' => 'David Chen', 'role' => 'Appeals Specialist', 'stat' => '92% appeal success rate', 'description' => 'David found details that changed everything about my case.', 'ctaText' => "Explore David's Appeal Process", 'ctaLink' => '#', 'image' => '/assets/images/expert3.png'],
        ['name' => 'David Chen', 'role' => 'Youth Justice Expert', 'stat' => '25 years courtroom experience', 'description' => 'David found details that changed everything about my case.', 'ctaText' => "Learn About David's Approach", 'ctaLink' => '#', 'image' => '/assets/images/expert4.png'],
    ],
];

// Sub-topic dropdown shown under each inner service on a practice area detail page
$innerDropdownData = [
    ['id' => 'possession', 'title' => 'Possession', 'description' => 'Possession charges cover holding a prohibited substance, even briefly or on behalf of someone else.', 'points' => [
        "Even holding drugs for someone else (e.g., at a festival) counts as possession.",
        "Large amounts may be treated as commercial possession, dealt with in higher courts.",
        "If charged, seek legal guidance immediately to explore defence options.",
        "The burden shifts: the accused must prove they didn't know or suspect drugs were present.",
        "All occupants of a house or car can be deemed in possession if drugs are found.",
    ]],
    ['id' => 'trafficking', 'title' => 'Trafficking', 'description' => 'Details about drug trafficking laws, penalties, and legal defences.', 'points' => [
        'Trafficking charges depend on intent to sell or distribute.',
        'Large quantities can automatically trigger trafficking charges.',
    ]],
    ['id' => 'producing', 'title' => 'Producing', 'description' => 'Production of controlled substances, even small amounts, may lead to charges.', 'points' => [
        'Growing cannabis plants can be considered production.',
        'Operating labs for synthesis is treated as a serious criminal offence.',
    ]],
    ['id' => 'drug-diversion', 'title' => 'Drug Diversion', 'description' => 'Drug diversion programs aim to rehabilitate instead of prosecute.', 'points' => [
        'Eligibility varies by jurisdiction.',
        'May include treatment, education, or counselling instead of conviction.',
    ]],
    ['id' => 'synthetics', 'title' => 'Synthetics', 'description' => 'Synthetic drugs are treated under the same framework as traditional drugs.', 'points' => [
        'Possession and trafficking penalties apply equally.',
        'Emerging substances can be automatically scheduled.',
    ]],
    ['id' => 'steroids', 'title' => 'Steroids', 'description' => 'Possession and supply of steroids without prescription is illegal.', 'points' => [
        'Importation without a permit is a criminal offence.',
        'Penalties depend on the scale of supply.',
    ]],
    ['id' => 'proceeds-of-crime', 'title' => 'Proceeds Of Crime', 'description' => 'Authorities can seize assets believed to be derived from crime.', 'points' => [
        'The burden of proof may be reversed.',
        'Property can be frozen pending investigation.',
    ]],
];

// ---------------------------------------------------------------------
// Fixed prices / legal fees (src/data/overall.ts legalFeesData)
// Every service in the original data shares the same 3-tier fee
// structure, so it is defined once here (DRY) and referenced below
// instead of being repeated 28 times as in the source file.
// ---------------------------------------------------------------------
$standardFeeTiers = [
    ['location' => 'Courts in Sydney City and Metropolitan Area', 'cost' => '$2000 + GST'],
    ['location' => 'Courts in Other NSW Cities (Gosford, Newcastle, Wollongong etc.)', 'cost' => '$3000 + GST'],
    ['location' => 'Courts in NSW Regional Areas', 'cost' => '$4000 + GST and travel disbursements if required'],
];

function fee_service(string $id, string $title, string $image, array $tiers): array
{
    return ['id' => $id, 'title' => $title, 'image' => $image, 'fees' => $tiers];
}

$legalFeesData = [
    'title' => 'Legal Fees by Practice Area',
    'subtitle' => 'Our team of experienced family lawyers is dedicated to providing comprehensive assistance and support in matters related to divorce, child custody, spousal support, and more.',
    'practiceAreas' => [
        ['id' => 'criminal-law', 'name' => 'Criminal Lawyers', 'services' => [
            fee_service('drugs-offences', 'Drugs Offences', '/assets/images/drug-offence.png', $standardFeeTiers),
            fee_service('traffic-offences', 'Traffic Offences', '/assets/images/traffic-offence.png', $standardFeeTiers),
            fee_service('domestic-violence', 'Domestic/Family Violence', '/assets/images/family-voilence.png', $standardFeeTiers),
            fee_service('murder', 'Murder & Manslaughter', '/assets/images/murder-offence.png', $standardFeeTiers),
            fee_service('robbery', 'Robbery & Burglary Charges', '/assets/images/robbery-offence.png', $standardFeeTiers),
            fee_service('firearms', 'Firearm & Weapons Charges', '/assets/images/firearm-offence.png', $standardFeeTiers),
        ]],
        ['id' => 'business-law', 'name' => 'Business Law', 'services' => [
            fee_service('drugs-offences', 'Drugs Offences', '/assets/images/drug-offence.png', $standardFeeTiers),
            fee_service('traffic-offences', 'Traffic Offences', '/assets/images/traffic-offence.png', $standardFeeTiers),
            fee_service('firearms', 'Firearm & Weapons Charges', '/assets/images/firearm-offence.png', $standardFeeTiers),
        ]],
        ['id' => 'commercial-law', 'name' => 'Commercial Law', 'services' => [
            fee_service('drugs-offences', 'Drugs Offences', '/assets/images/drug-offence.png', $standardFeeTiers),
            fee_service('traffic-offences', 'Traffic Offences', '/assets/images/traffic-offence.png', $standardFeeTiers),
            fee_service('domestic-violence', 'Domestic/Family Violence', '/assets/images/family-voilence.png', $standardFeeTiers),
            fee_service('murder', 'Murder & Manslaughter', '/assets/images/murder-offence.png', $standardFeeTiers),
            fee_service('robbery', 'Robbery & Burglary Charges', '/assets/images/robbery-offence.png', $standardFeeTiers),
        ]],
        ['id' => 'debt-recovery', 'name' => 'Debt Recovery', 'services' => [
            fee_service('drugs-offences', 'Drugs Offences', '/assets/images/drug-offence.png', $standardFeeTiers),
            fee_service('traffic-offences', 'Traffic Offences', '/assets/images/traffic-offence.png', $standardFeeTiers),
            fee_service('domestic-violence', 'Domestic/Family Violence', '/assets/images/family-voilence.png', $standardFeeTiers),
            fee_service('murder', 'Murder & Manslaughter', '/assets/images/murder-offence.png', $standardFeeTiers),
            fee_service('robbery', 'Robbery & Burglary Charges', '/assets/images/robbery-offence.png', $standardFeeTiers),
            fee_service('firearms', 'Firearm & Weapons Charges', '/assets/images/firearm-offence.png', $standardFeeTiers),
        ]],
        ['id' => 'family-law', 'name' => 'Family Law', 'services' => [
            fee_service('drugs-offences', 'Drugs Offences', '/assets/images/drug-offence.png', $standardFeeTiers),
            fee_service('traffic-offences', 'Traffic Offences', '/assets/images/traffic-offence.png', $standardFeeTiers),
            fee_service('domestic-violence', 'Domestic/Family Violence', '/assets/images/family-voilence.png', $standardFeeTiers),
            fee_service('firearms', 'Firearm & Weapons Charges', '/assets/images/firearm-offence.png', $standardFeeTiers),
        ]],
        ['id' => 'immigration-law', 'name' => 'Immigration Law', 'services' => [
            fee_service('domestic-violence', 'Domestic/Family Violence', '/assets/images/family-voilence.png', $standardFeeTiers),
            fee_service('murder', 'Murder & Manslaughter', '/assets/images/murder-offence.png', $standardFeeTiers),
            fee_service('robbery', 'Robbery & Burglary Charges', '/assets/images/robbery-offence.png', $standardFeeTiers),
            fee_service('firearms', 'Firearm & Weapons Charges', '/assets/images/firearm-offence.png', $standardFeeTiers),
        ]],
    ],
];

// ---------------------------------------------------------------------
// Contact page (src/components/sections/contact/Directions.tsx, officeInfo, contactData)
// ---------------------------------------------------------------------
$directions = [
    ['id' => 'parking', 'title' => 'PARKING', 'description' => "Claim your discounted parking rates by validating your ticket at our building's car park when visiting our office.", 'icon' => '/assets/icons/parking.svg'],
    ['id' => 'subway', 'title' => 'BY TRAIN', 'description' => 'Take the train to Town Hall or St James Station, both an easy walk from our World Tower office.', 'icon' => '/assets/icons/subway.svg'],
    ['id' => 'bus', 'title' => 'BY BUS', 'description' => 'Multiple city bus routes stop within a short walk of Meriton Suites World Tower.', 'icon' => '/assets/icons/bus.svg'],
    ['id' => 'walk', 'title' => 'ON FOOT', 'description' => 'Our office is centrally located in the Sydney CBD, an easy walk from Town Hall and Pitt Street Mall.', 'icon' => '/assets/icons/waalking.svg'],
];

$officeInfo = [
    'name' => 'DM Legal Services',
    'address' => SITE_ADDRESS_SHORT,
    'phoneNumbers' => [SITE_PHONE_DISPLAY],
    'email' => SITE_EMAIL,
    'hours' => SITE_OFFICE_HOURS,
    'mapEmbedUrl' => dm_legal_get_setting( 'maps_embed_url' ),
    'mapsUrl' => SITE_MAPS_URL,
    'instagram' => SITE_INSTAGRAM_URL,
    'facebook' => SITE_FACEBOOK_URL,
];

// ---------------------------------------------------------------------
// Book-a-lawyer consultation form (src/app/book-your-lawyer)
// ---------------------------------------------------------------------
$contactData = [
    'title' => 'DM Legal Services',
    'address' => SITE_ADDRESS_SHORT,
    'telephone' => SITE_PHONE_DISPLAY,
    'officeMobile' => SITE_PHONE_TEL,
    'email' => SITE_EMAIL,
    'officeHour' => 'Mon-Fri, 8:30 am - 5:30pm',
];

$stepsData = [
    ['id' => 1, 'title' => 'Book a free 15 minute call to discuss the next process.'],
    ['id' => 2, 'title' => 'Book and attend an intake session (30 - 60 min).'],
    ['id' => 3, 'title' => 'We will invite the other party to attend their own intake session.'],
    ['id' => 4, 'title' => 'Attend a mediation (half day / full day).'],
];

$consultationOptions = [
    ['id' => 1, 'title' => 'Face-to-Face', 'subtitle' => 'Visit our office', 'icon' => '/assets/icons/user.svg'],
    ['id' => 2, 'title' => 'Zoom', 'subtitle' => 'Join remotely via Zoom', 'icon' => '/assets/icons/zoom-icon.svg'],
    ['id' => 3, 'title' => 'Telephone Call', 'subtitle' => 'Call our lawyer', 'icon' => '/assets/icons/phone.svg'],
    ['id' => 4, 'title' => 'Microsoft Teams', 'subtitle' => 'Join remotely via Teams', 'icon' => '/assets/icons/microsoft.svg'],
];

// ---------------------------------------------------------------------
// Legal text pages (src/data/overall.ts PrivacyPolicy / TermsAndConditions / Disclaimer)
// ---------------------------------------------------------------------
$privacyPolicy = [
    ['title' => '1. Introduction', 'content' => "At DM Legal Services (\"we\", \"our\", \"us\"), we are committed to providing quality services while protecting your privacy. This Privacy Policy explains how we collect, use, store, and safeguard your Personal Information in compliance with the Australian Privacy Principles (APPs) under the Privacy Act 1988 (Cth).\n\nBy using our website or services, you acknowledge that you have read and agreed to this policy. If you do not agree, please discontinue use of our website and services. You can access the APPs at: https://www.oaic.gov.au/."],
    ['title' => '2. Personal Information We Collect', 'content' => "**What is Personal Information?**\nPersonal Information identifies an individual. Examples include:\n- Name, address, email, phone/fax numbers\n- Documents submitted for legal assessment\n- Other information voluntarily provided for consultations\n\n**How We Collect It:**\nWe may collect information via:\n- Website forms or emails\n- Telephone or in-person communications\n- Third-party sources (with your consent)\n- Cookies and tracking technologies\n\nWe do not guarantee links or privacy policies of third-party websites."],
    ['title' => '3. Sensitive Information', 'content' => "Sensitive information may include details about:\n- Health or medical history\n- Racial or ethnic origin\n- Religious or political beliefs\n- Membership of professional associations\n- Criminal record\n\nWe only use sensitive information:\n- For the purpose it was collected\n- For related purposes you would reasonably expect\n- With your consent or as required by law"],
    ['title' => '4. How We Use Your Information', 'content' => "We use Personal Information to:\n- Provide legal services and consultations\n- Respond to inquiries and bookings\n- Verify identity and documentation\n- Maintain internal records for auditing and service improvement\n- Send updates or promotional communications (you may opt-out)\n- Analyze website performance\n\nWe do **not** sell, trade, or rent your Personal Information."],
    ['title' => '5. Disclosure to Third Parties', 'content' => "Your information may be disclosed:\n- With your consent\n- To legal partners or professionals for service delivery\n- As required or authorised by law\n\nWe take reasonable steps to ensure any third-party disclosure is secure and confidential."],
    ['title' => '6. Security of Personal Information', 'content' => "We store your Personal Information securely to prevent misuse, loss, unauthorized access, or disclosure.\n- Data transmission is encrypted (SSL)\n- Access to information is restricted\n- Sensitive information is anonymized where possible\n\nWhen no longer required, Personal Information is securely destroyed or permanently de-identified. Client files are retained for a minimum of 7 years."],
    ['title' => '7. Access & Correction', 'content' => "You may request access to your Personal Information to update or correct it. We may require identification before providing access. While we do not charge for access requests, administrative fees may apply for copies.\n\nTo exercise your rights, please contact us using the details in the Contact section."],
    ['title' => '8. Maintaining Accuracy', 'content' => "We take reasonable steps to ensure your Personal Information is accurate and up-to-date. Please notify us if you identify any errors or outdated information so we can update our records promptly."],
    ['title' => '9. Cookies & Tracking', 'content' => "We may use cookies and similar technologies to:\n- Improve website functionality\n- Recognize returning visitors\n- Analyze traffic patterns\n- Save preferences\n\nYou can disable cookies in your browser, but some features may be affected."],
    ['title' => '10. Policy Updates', 'content' => "We may update this Privacy Policy to reflect changes in law, technology, or business practices. The latest version will always be available on our website. We encourage periodic review of this page."],
    ['title' => '11. Privacy Complaints & Enquiries', 'content' => "For any questions, complaints, or requests regarding your Personal Information, contact us:\n- Email: " . SITE_EMAIL . "\n- Phone: " . SITE_PHONE_DISPLAY . "\n- Address: " . SITE_ADDRESS_SHORT . "\n\nWe will respond promptly and take appropriate action to resolve any issues."],
];

$termsAndConditions = [
    ['title' => '1. Introduction', 'content' => "Welcome to DM Legal Services (\"we\", \"our\", \"us\"). These Terms and Conditions govern your use of our website, services, and any content or materials provided by us.\n\nBy accessing or using our website, you agree to be bound by these Terms and Conditions. If you do not agree, please discontinue the use of our website and services immediately."],
    ['title' => '2. Definitions', 'content' => "For the purpose of these Terms:\n- **\"Website\"** refers to the DM Legal Services online platform.\n- **\"Services\"** refers to all legal consultation, documentation, support, or advisory services provided by us.\n- **\"User\", \"You\", \"Your\"** refers to anyone who accesses or uses our website or services.\n- **\"Content\"** refers to any text, graphics, documents, forms, or media displayed on our website."],
    ['title' => '3. Use of Our Services', 'content' => "By using our services, you agree to:\n- Provide accurate and truthful information\n- Use our website for lawful purposes only\n- Not engage in fraudulent, harmful, or unauthorized activities\n- Not attempt to breach, modify, or misuse website features\n- Not copy, redistribute, or misuse our content without permission\n\nWe reserve the right to refuse service or terminate user access at our discretion."],
    ['title' => '4. Legal Services & Consultation', 'content' => "DM Legal Services provides professional legal support based on the information provided by the client. However:\n- Our consultation does not guarantee a particular legal outcome\n- Final decisions are influenced by external legal authorities and jurisdictional procedures\n- Users are responsible for providing accurate, up-to-date information\n- Misrepresentation of information may result in termination of service without refund\n\nAll advice is given based on available details and governed by applicable legal frameworks."],
    ['title' => '5. Payments & Billing', 'content' => "By using our paid services, you agree to:\n- Pay the fees associated with the selected service\n- Ensure that payment information provided is accurate\n- Understand that fees may vary depending on case complexity\n\n**Refund Policy**\nPayments made for consultation or legal services are generally non-refundable unless:\n- An administrative error occurred\n- A duplicate payment was made\n- A service was not initiated or delivered\n\nRefund eligibility is determined on a case-by-case basis."],
    ['title' => '6. User Responsibilities', 'content' => "You agree to:\n- Provide complete and truthful information for service processing\n- Ensure submitted documents are valid and legally obtained\n- Follow instructions provided by our legal team\n- Avoid misuse or misrepresentation of our consultation results\n- Keep account, communication, and document-sharing secure\n\nYou are responsible for maintaining confidentiality of any legal documents or correspondence shared with us."],
    ['title' => '7. Intellectual Property Rights', 'content' => "All website content, including text, graphics, logos, icons, downloadable materials, and digital content, is the exclusive property of DM Legal Services.\n\nYou may not:\n- Copy or reproduce website content\n- Modify or create derivative works\n- Redistribute or republish content without permission\n\nUnauthorized use may result in legal action."],
    ['title' => '8. Third-Party Links & Services', 'content' => "Our website may contain links to third-party websites or services. These are provided for convenience only.\n\nWe do not own, control, or endorse third-party content, and we are not responsible for:\n- Their accuracy\n- Their privacy practices\n- Their terms of use\n\nYou are encouraged to review third-party policies before interacting."],
    ['title' => '9. Limitation of Liability', 'content' => "To the fullest extent permitted by law, DM Legal Services is not liable for:\n- Any financial losses resulting from legal decisions\n- Errors caused by inaccurate information provided by the user\n- Delays due to third-party systems or government processes\n- Technical issues, interruptions, or system downtime\n\nWe provide services based on professional standards, but outcomes cannot be guaranteed."],
    ['title' => '10. Disclaimer', 'content' => "All information provided on our website is for general informational purposes and should not be interpreted as legal advice unless provided directly through a paid consultation.\n\nWe are not responsible for any actions taken based solely on website content without formal consultation."],
    ['title' => '11. Indemnification', 'content' => "You agree to indemnify and hold DM Legal Services harmless from:\n- Claims\n- Damages\n- Liabilities\n- Losses\n- Legal fees\n\nResulting from misuse of our website, violation of our Terms, or harmful activities carried out through your access."],
    ['title' => '12. Service Modifications & Updates', 'content' => "We reserve the right to:\n- Modify or discontinue services\n- Update website content\n- Change pricing or structure\n- Improve or remove website features\n\nThese changes may occur without prior notice. Continued use constitutes acceptance of updated terms."],
    ['title' => '13. Termination', 'content' => "We may suspend or terminate your access if:\n- You violate these Terms\n- You provide false or misleading information\n- You misuse our services\n- We detect unauthorized access\n\nUpon termination, you must discontinue use of all website materials and services immediately."],
    ['title' => '14. Governing Law', 'content' => "These Terms & Conditions are governed by the laws of the applicable jurisdiction in which DM Legal Services operates.\n\nAny disputes shall be resolved under the legal authority of the region's courts."],
    ['title' => '15. Changes to These Terms', 'content' => "We may update or revise these Terms & Conditions at any time. The updated version will be posted on this page with the revised date.\n\nContinued use of our website signifies acceptance of the revised Terms."],
    ['title' => '16. Contact Us', 'content' => "For questions, concerns, or clarification regarding these Terms & Conditions, please contact us:\n- Email: " . SITE_EMAIL . "\n- Phone: " . SITE_PHONE_DISPLAY . "\n- Address: " . SITE_ADDRESS_SHORT . "\n\nWe will respond to your query as soon as possible."],
];

$disclaimer = [
    ['title' => '1. Introduction', 'content' => "This Disclaimer outlines the limitations and responsibilities relating to the information, services, and content provided by DM Legal Services (\"we\", \"our\", \"us\"). By accessing our website or using our services, you acknowledge that you have read and understood this Disclaimer. If you disagree with any part of this Disclaimer, please discontinue use of our website and services immediately."],
    ['title' => '2. No Legal Advice', 'content' => "All information provided on our website, including articles, guides, resources, and general communication, is intended for informational purposes only. It should not be considered as formal legal advice or a replacement for professional consultation.\n\nLegal outcomes depend on the specifics of each case, and general information cannot guarantee results. For personalized advice, users must contact us directly for a formal consultation."],
    ['title' => '3. Accuracy of Information', 'content' => "While we strive to ensure the accuracy, reliability, and timeliness of the information published on our website, we make no guarantees that:\n- All information is complete\n- All content is error-free\n- All resources are up-to-date\n- All pages will remain available at all times\n\nLaws, regulations, and legal procedures frequently change. We are not responsible for any outdated or incorrect information found on the website."],
    ['title' => '4. No Attorney-Client Relationship', 'content' => "Use of our website, communication through forms, messages, or email does **not** create an attorney-client relationship. An official legal relationship is established only when:\n- You schedule and complete a consultation\n- Required documents are verified\n- A service agreement or retainer is signed (if applicable)\n\nUntil then, no legal obligations are formed between you and DM Legal Services."],
    ['title' => '5. Limitation of Liability', 'content' => "DM Legal Services is not liable for any losses, damages, or consequences resulting from:\n- Reliance on website content\n- Misinterpretation of general information\n- Delays or unavailability of the website\n- Inaccurate or incomplete user-submitted information\n- Use of third-party services linked to our website\n\nYour use of the website and services is entirely at your own risk."],
    ['title' => '6. External & Third-Party Links', 'content' => "Our website may include links to external websites, legal resources, or third-party tools. These are provided only for informational or convenience purposes.\n\nWe do not control or endorse third-party websites, nor are we responsible for:\n- Their accuracy\n- Their content\n- Their privacy practices\n- Their legal compliance\n\nUsers are encouraged to review the terms and policies of any linked websites."],
    ['title' => '7. Service Limitations', 'content' => "Our legal guidance and consultation are limited to the information provided by the user. We cannot be held responsible for:\n- Errors arising from incomplete or incorrect user inputs\n- Legal decisions influenced by external authorities\n- Rejection of legal applications due to missing, incorrect, or late-submitted documents\n\nWe provide support based on professional standards but do not guarantee specific legal outcomes."],
    ['title' => '8. Professional Relationship', 'content' => "All communication, responses, documents, or materials shared during consultation are intended solely for the client who requested the service.\n\nUsers agree not to misuse, misinterpret, or publicly distribute any materials or guidance provided by DM Legal Services."],
    ['title' => '9. Changes to the Website', 'content' => "We may modify, update, or remove content from our website at any time without notice. This includes text, links, pages, services, pricing, or resources.\n\nWe are not responsible for any consequences resulting from such changes."],
    ['title' => '10. No Guarantee of Outcomes', 'content' => "Legal cases depend on various factors beyond our control, such as:\n- Government decisions\n- Court judgments\n- Administrative delays\n- Legal policy changes\n- Document verification outcomes\n\nTherefore, we do not guarantee the success of any legal case, application, or representation."],
    ['title' => '11. Indemnification', 'content' => "By using our website or services, you agree to indemnify and hold DM Legal Services harmless from any claims, damages, losses, or expenses arising from:\n- Misuse of our content\n- Misinterpretation of information\n- Violation of our terms or policies\n- Unauthorized use of website materials"],
    ['title' => '12. Changes to This Disclaimer', 'content' => "We may update or revise this Disclaimer from time to time based on operational, legal, or regulatory needs.\n\nThe updated version will be posted on this page with a revised date. Continued use of our website signifies your acceptance of the updated Disclaimer."],
    ['title' => '13. Contact Us', 'content' => "If you have any questions or concerns regarding this Disclaimer or any part of our website, please contact us:\n- Email: " . SITE_EMAIL . "\n- Phone: " . SITE_PHONE_DISPLAY . "\n- Address: " . SITE_ADDRESS_SHORT . "\n\nWe will respond to your inquiry as soon as possible."],
];
