#!/bin/sh

psql -h localhost -d empresa -U empresa < comunes/empresa.sql
