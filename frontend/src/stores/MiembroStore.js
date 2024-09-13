import { ref } from "vue";
import { defineStore } from "pinia";
import MiembrosService from "@/services/MiembrosService";
import { showDialog } from "@/Utils/Dialogs";
import axios from "axios";

export const useMiembroStore = defineStore("miembro", () => {
  const miembro = ref({});
  const loading = ref(false);
  const enviarInformacion = async () => {
    if (miembro.value.id_miembro) {
      await MiembrosService.put(miembro.value, miembro.value.id_miembro);
    } else {
      await MiembrosService.post(miembro.value);
    }
  };
  return {
    enviarInformacion,
    miembro,
    loading
  };
});
