const express = require('express');
const sqlite3 = require('sqlite3').verbose();
const bodyParser = require('body-parser');
const path = require('path');
const app = express();
const dbFile = path.join(__dirname,'db.sqlite');
const db = new sqlite3.Database(dbFile);


app.use(bodyParser.json());
app.use(express.static(path.join(__dirname,'..','frontend')));



const initSql = `PRAGMA foreign_keys = ON;`;
db.serialize(()=>{
  db.run(initSql);
  db.run(`CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL
  )`);
  db.run(`CREATE TABLE IF NOT EXISTS tasks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    description TEXT NOT NULL,
    sector TEXT NOT NULL,
    priority TEXT NOT NULL,
    status TEXT DEFAULT 'a fazer',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
  )`);
});



app.post('/api/users', (req,res)=>{
const {name,email} = req.body;
if(!name||!email) return res.status(400).json({error:'Todos campos obrigatórios'});
const stmt = db.prepare('INSERT INTO users(name,email) VALUES(?,?)');
stmt.run(name,email,function(err){
if(err) return res.status(500).json({error:err.message});
res.status(201).json({id:this.lastID});
});
});


app.get('/api/users', (req,res)=>{
db.all('SELECT id,name,email FROM users',[],(err,rows)=>{ if(err) return res.status(500).json({error:err.message}); res.json(rows); });
});


app.post('/api/tasks',(req,res)=>{
const {user_id,description,sector,priority} = req.body;
if(!user_id||!description||!sector||!priority) return res.status(400).json({error:'Todos campos obrigatórios'});
const sql = `INSERT INTO tasks(user_id,description,sector,priority,status) VALUES(?,?,?,?, 'a fazer')`;
db.run(sql,[user_id,description,sector,priority],function(err){ if(err) return res.status(500).json({error:err.message}); res.status(201).json({id:this.lastID}); });
});


app.get('/api/tasks', (req,res)=>{
const sql = `SELECT t.*, u.name as user_name FROM tasks t JOIN users u ON t.user_id = u.id ORDER BY created_at DESC`;
db.all(sql,[],(err,rows)=>{ if(err) return res.status(500).json({error:err.message}); res.json(rows); });
});


app.put('/api/tasks/:id',(req,res)=>{
const id = req.params.id;
const {description,sector,priority,status,user_id} = req.body;
if(!description||!sector||!priority||!status||!user_id) return res.status(400).json({error:'Todos campos obrigatórios'});
const sql = `UPDATE tasks SET description=?, sector=?, priority=?, status=?, user_id=? WHERE id=?`;
db.run(sql,[description,sector,priority,status,user_id,id],function(err){ if(err) return res.status(500).json({error:err.message}); res.json({changes:this.changes}); });
});


app.delete('/api/tasks/:id',(req,res)=>{
const id = req.params.id;
db.run('DELETE FROM tasks WHERE id=?',[id], function(err){ if(err) return res.status(500).json({error:err.message}); res.json({deleted:this.changes}); });
});


const PORT = process.env.PORT||3000;
app.listen(PORT, ()=>console.log(`Server running on port ${PORT}`));
