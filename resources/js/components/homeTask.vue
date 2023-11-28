<!-- CreateTask.vue -->

<template>
    <div>
      <h2>Créer une nouvelle tâche</h2>
  
      <form @submit.prevent="createTask">
        <div class="form-group">
          <label for="title">Titre de la tâche</label>
          <input v-model="task.title" type="text" id="title" class="form-control" required>
        </div>
  
        <div class="form-group">
          <label for="description">Description de la tâche</label>
          <textarea v-model="task.description" id="description" class="form-control"></textarea>
        </div>
  
        <div class="form-group">
          <label for="due_date">Date d'échéance</label>
          <input v-model="task.due_date" type="date" id="due_date" class="form-control">
        </div>
  
        <div class="form-group">
          <label for="priority">Priorité</label>
          <input v-model="task.priority" type="number" id="priority" class="form-control">
        </div>
        <div class="form-group">
    <label for="assigned_email">E-mail de la personne assignée</label>
    <input v-if="task.assigned_email === 'other'" v-model="task.assigned_email_manual" type="email" id="assigned_email_manual" class="form-control" placeholder="Saisir l'e-mail manuellement">
    <select v-else v-model="task.assigned_email" id="assigned_email" class="form-control">
        <option v-for="user in users" :key="user.id" :value="user.email">{{ user.name }} - {{ user.email }}</option>
        <option value="other">Saisir manuellement</option>
    </select>
</div>


        <div class="form-group">
        <label for="status">Statut</label>
        <select v-model="task.status" id="status" class="form-control">
          <option value="A Faire">A Faire</option>
          <option value="En Cours">En Cours</option>
          <option value="Terminée">Terminée</option>
        </select>
      </div>
  
        <div class="d-flex justify-content-between mt-3">
      <!-- Bouton "Créer la tâche" -->
      <button @click="goBack" class="btn btn-primary">Créer la tâche</button>
        </div>
        <div v-if="successMessage">
  <p>Le message de succès est défini!</p>
  <div style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 999;">
    {{ successMessage }}
  </div>
</div>
        
      </form>
    </div>
  </template>
  
<script>
  export default {
    data() {
      return {
        task: {
          title: '',
          description: '',
          due_date: '',
          priority: '',
          status: 'A faire',
          assigned_email: '',
          assigned_email_manual: '',
        },
        successMessage: null,
        users: [],
      };
    },
    created() {
    this.fetchUsers();
  },
    methods: {
      createTask() {
        // Logique pour envoyer la requête API (par exemple, à une route Laravel)
        // pour créer la tâche dans la base de données
        axios.post('/api/tasks', this.task)
          .then(response => {
            // Gérer la réponse, par exemple, rediriger l'utilisateur ou afficher un message de succès
            console.log(response.data);
            this.successMessage = 'Tâche créée avec succès!';
            this.resetSuccessMessage();
          })
          .catch(error => {
            // Gérer les erreurs, par exemple, afficher un message d'erreur
            console.error(error);
          });
      },
      resetSuccessMessage() {
      setTimeout(() => {
        this.successMessage = null;
      }, 5000); // Réinitialisez le message après 5 secondes (ajustez le délai selon vos préférences)
    },
      goBack() {
    window.history.back();
  },
  fetchUsers() {
    axios.get('/users')
      .then(response => {
        this.users = response.data.users;
      })
      .catch(error => {
        console.error(error);
      });
  },

    },
  };
  </script>
  
  <style scoped>
  /* Styles spécifiques au composant */
  </style>
  