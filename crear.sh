#!/bin/sh

psql -h localhost -d empresa -U empresa < empresa.sql
