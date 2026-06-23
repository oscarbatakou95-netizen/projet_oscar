/* ═══════════════════════════════════════════
   OSCAR BATAKOU — Portfolio Personnel
   script.js
═══════════════════════════════════════════ */

"use strict";

/* ── 1. Navbar scroll ─────────────────────── */
(function () {
  const navbar = document.getElementById("navbar");
  const onScroll = () => {
    navbar.classList.toggle("scrolled", window.scrollY > 40);
  };
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();
})();

/* ── 2. Mobile nav toggle ─────────────────── */
(function () {
  const toggle = document.getElementById("navToggle");
  const links  = document.querySelector(".nav-links");
  if (!toggle || !links) return;

  toggle.addEventListener("click", () => {
    links.classList.toggle("open");
    const open = links.classList.contains("open");
    toggle.setAttribute("aria-expanded", open);
  });

  links.querySelectorAll("a").forEach((a) => {
    a.addEventListener("click", () => links.classList.remove("open"));
  });

  document.addEventListener("click", (e) => {
    if (!toggle.contains(e.target) && !links.contains(e.target)) {
      links.classList.remove("open");
    }
  });
})();

/* ── 3. Typed effect (hero) ───────────────── */
(function () {
  const el     = document.getElementById("typed-text");
  if (!el) return;

  const words  = [
    "expériences web.",
    "interfaces modernes.",
    "solutions sur mesure.",
    "designs percutants.",
    "architectures réseau.",
    "applications robustes.",
  ];

  let wordIndex  = 0;
  let charIndex  = 0;
  let isDeleting = false;
  let pause      = false;

  function type() {
    if (pause) return;

    const word    = words[wordIndex];
    const current = isDeleting
      ? word.substring(0, charIndex - 1)
      : word.substring(0, charIndex + 1);

    el.textContent = current;
    charIndex      = isDeleting ? charIndex - 1 : charIndex + 1;

    let delay = isDeleting ? 55 : 90;

    if (!isDeleting && charIndex === word.length) {
      delay      = 1800;
      isDeleting = true;
    } else if (isDeleting && charIndex === 0) {
      isDeleting = false;
      wordIndex  = (wordIndex + 1) % words.length;
      delay      = 350;
    }

    setTimeout(type, delay);
  }

  setTimeout(type, 800);
})();

/* ── 4. Scroll reveal ─────────────────────── */
(function () {
  const targets = document.querySelectorAll(
    ".service-card, .project-card, .skill-item, .tech-tag, .about-content, .about-visual, .contact-info, .contact-form-wrap, .stat, .cert-card"
  );

  targets.forEach((el) => el.classList.add("reveal"));

  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          io.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.12, rootMargin: "0px 0px -40px 0px" }
  );

  targets.forEach((el) => io.observe(el));
})();

/* ── 5. Skill bars animation ──────────────── */
(function () {
  const fills = document.querySelectorAll(".skill-fill");
  if (!fills.length) return;

  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          setTimeout(() => entry.target.classList.add("animated"), 200);
          io.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.4 }
  );

  fills.forEach((f) => io.observe(f));
})();

/* ── 6. Active nav link on scroll ────────── */
(function () {
  const sections = document.querySelectorAll("section[id]");
  const navLinks = document.querySelectorAll(".nav-links a");

  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const id = entry.target.id;
          navLinks.forEach((a) => {
            a.classList.toggle("active", a.getAttribute("href") === `#${id}`);
          });
        }
      });
    },
    { threshold: 0.4 }
  );

  sections.forEach((s) => io.observe(s));
})();

/* ── 7. Contact form ──────────────────────── */
(function () {
  const form      = document.getElementById("contactForm");
  const submitBtn = document.getElementById("submitBtn");
  const success   = document.getElementById("formSuccess");
  const error     = document.getElementById("formError");

  if (!form) return;

  /* Simple field validation */
  function validateField(field) {
    const val = field.value.trim();
    if (field.hasAttribute("required") && !val) {
      field.classList.add("error");
      return false;
    }
    if (field.type === "email" && val && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
      field.classList.add("error");
      return false;
    }
    field.classList.remove("error");
    return true;
  }

  form.querySelectorAll("input, select, textarea").forEach((field) => {
    field.addEventListener("input", () => validateField(field));
    field.addEventListener("blur",  () => validateField(field));
  });

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    /* Validate all fields */
    const fields  = form.querySelectorAll("input, select, textarea");
    let   isValid = true;
    fields.forEach((f) => { if (!validateField(f)) isValid = false; });

    if (!isValid) {
      const firstError = form.querySelector(".error");
      if (firstError) firstError.focus();
      return;
    }

    /* Collect data */
    const data = {
      prenom:   form.fname.value.trim(),
      nom:      form.lname.value.trim(),
      email:    form.email.value.trim(),
      phone:    form.phone.value.trim(),
      service:  form.service.value,
      budget:   form.budget.value,
      message:  form.message.value.trim(),
      date:     new Date().toLocaleString("fr-FR"),
    };

    /* UI: loading state */
    submitBtn.querySelector(".btn-text").style.display    = "none";
    submitBtn.querySelector(".btn-loading").style.display = "inline";
    submitBtn.disabled = true;
    success.style.display = "none";
    error.style.display   = "none";

    /* ─────────────────────────────────────────────────────────
       INTÉGRATION FORMSPREE
       Remplacez YOUR_FORM_ID par votre ID Formspree.
       Créez un compte gratuit sur https://formspree.io
       puis remplacez la ligne ci-dessous par votre endpoint.
       Exemple : https://formspree.io/f/xpwzabcd
    ───────────────────────────────────────────────────────── */
    const FORMSPREE_ENDPOINT = "https://formspree.io/f/YOUR_FORM_ID";

    try {
      const res = await fetch(FORMSPREE_ENDPOINT, {
        method:  "POST",
        headers: { "Content-Type": "application/json", Accept: "application/json" },
        body:    JSON.stringify(data),
      });

      if (res.ok) {
        success.style.display = "block";
        form.reset();
        fields.forEach((f) => f.classList.remove("error"));
        /* Scroll to success message */
        success.scrollIntoView({ behavior: "smooth", block: "nearest" });
      } else {
        throw new Error("Réponse serveur non-ok");
      }
    } catch (err) {
      /* Fallback : ouvrir le client email par défaut */
      const subject = encodeURIComponent(`Demande de service — ${data.service}`);
      const body    = encodeURIComponent(
        `Prénom : ${data.prenom}\nNom : ${data.nom}\nEmail : ${data.email}\n` +
        `Téléphone : ${data.phone}\nService : ${data.service}\nBudget : ${data.budget}\n\n` +
        `Message :\n${data.message}`
      );
      window.location.href = `mailto:votreemail@exemple.com?subject=${subject}&body=${body}`;

      /* Affiche quand même un message positif côté UX */
      success.style.display = "block";
      success.textContent   = "✅ Votre client email va s'ouvrir pour finaliser l'envoi.";
    } finally {
      submitBtn.querySelector(".btn-text").style.display    = "inline";
      submitBtn.querySelector(".btn-loading").style.display = "none";
      submitBtn.disabled = false;
    }
  });
})();

/* ── 8. Smooth scroll for anchor links ───── */
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    const target = document.querySelector(this.getAttribute("href"));
    if (!target) return;
    e.preventDefault();
    const offset = 80;
    const top    = target.getBoundingClientRect().top + window.scrollY - offset;
    window.scrollTo({ top, behavior: "smooth" });
  });
});

/* ── 9. Subtle parallax on hero bg grid ──── */
(function () {
  const grid = document.querySelector(".hero-bg-grid");
  if (!grid || window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

  window.addEventListener(
    "scroll",
    () => {
      const y = window.scrollY;
      grid.style.transform = `translateY(${y * 0.15}px)`;
    },
    { passive: true }
  );
})();
