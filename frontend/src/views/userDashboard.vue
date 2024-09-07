<template>
    <div>
        <PrincipalLayout>
            <div class="">
                Hola
            </div>
        </PrincipalLayout>
    </div>
</template>

<script setup>
import PrincipalLayout from '@/components/Generals/PrincipalLayout.vue'
import UserStore from '@/stores/UserStore';
const userStore = UserStore()
const generateDeviceSessionId = () => {
    OpenPay.setId('mmfttydg740wodlzajks')
    OpenPay.setApiKey('sk_b66f2571e228430eba28aaf19716b69f')
      var deviceSessionId = OpenPay.deviceData.setup();
      console.log('Device Session ID:', deviceSessionId);
      return deviceSessionId;
    };
</script>
