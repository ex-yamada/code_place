<template>
<div class="flex_row">
    <ul :class="isFlexThree ? 'flex_03' : 'flex_02'">
        <li>
            <select
                v-model="department_id"
                @change="selectDepartment"
                class="mr-15"
                required>
                <option
                    v-for="(data, index) in departments"
                    :key="data.department_id"
                    :value="data.department_id"
                    >{{ data.department_name }}</option>
            </select>
            <p class="error_text" v-text="errorInfo.department_id" />
        </li>
        <li v-if="divisions[department_id] && divisions[department_id].length">
            <select
                v-model="division_id"
                @change="selectDivision"
                required>
                <option
                    v-for="(data, index) in divisions[department_id]"
                    :key="data.division_id"
                    :value="data.division_id">{{ data.division_name }}</option>
            </select>
            <p class="error_text" v-text="errorInfo.division_id" />
        </li>
        <li v-if="units[division_id] && units[division_id].length">
            <select
                v-model="unit_id"
                required>
                <option
                    v-for="(data, index) in units[division_id]"
                    :key="data.unit_id"
                    :value="data.unit_id">{{ data.unit_name }}</option>
            </select>
            <p class="error_text" v-text="errorInfo.unit_id" />
        </li>
    </ul>
    <input type="hidden" name="department_id" :value="department_id" />
    <input type="hidden" name="division_id" :value="division_id" />
    <input type="hidden" name="unit_id" :value="unit_id" />
</div>
</template>

<script>
export default {
    props: {
        OrganiZationGroup: {
            type: Object,
            required: true
        },
        oldOrganiZationGroup: {
            type: Object,
            required: true
        },
        errorInfo: {
            type: Object,
            required: true
        },
        defaultOrganiZationGroup: {
            type: Object,
            required: false
        },
    },
    components: {

    },
    created() {
        this.setData();
    },
    mounted() {},
    data() {
        return {
            department_id: 13,
            division_id: null,
            unit_id: null,
            departments: [],
            divisions: {},
            units: {},
        }
    },
    computed: {
        isFlexThree() {
            if (
                (this.divisions[this.department_id] && this.divisions[this.department_id].length)
                &&
                (this.units[this.division_id] && this.units[this.division_id].length)
                ) {
                return true;
            }
            return false;
        },
    },
    methods: {
        setData() {
            let divisions = {};
            let units = {};

            this.OrganiZationGroup.divisions.forEach(function(division, index){
                if (division.department_id) {
                    if (!divisions[division.department_id]) {
                        divisions[division.department_id] = [];
                    }
                    divisions[division.department_id].push(division);
                }
            });

            this.OrganiZationGroup.units.forEach(function(unit, index){
                if (unit.division_id) {
                    if (!units[unit.division_id]) {
                        units[unit.division_id] = [];
                    }
                    units[unit.division_id].push(unit);
                }
            });

            this.departments = this.OrganiZationGroup.departments;
            this.divisions   = divisions;
            this.units       = units;

            if (this.oldOrganiZationGroup.department_id) {
                this.department_id = this.oldOrganiZationGroup.department_id;
                this.division_id   = this.oldOrganiZationGroup.division_id;
                this.unit_id       = this.oldOrganiZationGroup.unit_id;
                return;
            }
            if (this.defaultOrganiZationGroup && this.defaultOrganiZationGroup.department_id) {
                this.department_id = this.defaultOrganiZationGroup.department_id;
                this.division_id   = this.defaultOrganiZationGroup.division_id;
                this.unit_id       = this.defaultOrganiZationGroup.unit_id;
                return;
            }
            this.selectDepartment();
            this.selectDivision();
        },
        selectDepartment() {
            this.division_id   = null;
            this.unit_id       = null;

            if (this.divisions[this.department_id] && this.divisions[this.department_id].length) {
                this.division_id = this.divisions[this.department_id][0].division_id;
            }
            if (this.units[this.division_id] && this.units[this.division_id].length) {
                this.unit_id = this.units[this.division_id][0].unit_id;
            }
        },
        selectDivision() {
            this.unit_id = null;

            if (this.units[this.division_id] && this.units[this.division_id].length) {
                this.unit_id = this.units[this.division_id][0].unit_id;
            }
        },
    }
}
</script>
