import EmployeeList from './components/Employees/EmployeeList';
import PositionsList from './components/Positions/PositionsList';
import CreateEmployee from './components/Employees/CreateEmployee';
import EditEmployee from './components/Employees/EditEmployee';
import CreatePosition from "./components/Positions/CreatePosition";
import EditPosition from "./components/Positions/EditPosition";
export const routes = [
    {path: '/employee-list',  component: EmployeeList},
    {path: '/positions',  component: PositionsList},
    {path: '/create-employee',  component: CreateEmployee},
    {path: '/edit-employee/:id',  component: EditEmployee},
    {path: '/create-position',  component: CreatePosition},
    {path: '/edit-position/:id',  component: EditPosition},
];
